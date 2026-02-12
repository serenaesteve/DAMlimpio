from __future__ import annotations
import csv
import io
import os
import sqlite3
from datetime import datetime
from flask import Flask, jsonify, render_template, request, send_file, abort

APP_DIR = os.path.dirname(os.path.abspath(__file__))
DB_PATH = os.path.join(APP_DIR, "data.sqlite3")

app = Flask(__name__)

def get_db() -> sqlite3.Connection:
    conn = sqlite3.connect(DB_PATH)
    conn.row_factory = sqlite3.Row
    return conn

def init_db() -> None:
    with get_db() as conn:
        conn.execute("""
        CREATE TABLE IF NOT EXISTS books (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            author TEXT NOT NULL,
            year INTEGER,
            created_at TEXT NOT NULL
        )
        """)
        cur = conn.execute("SELECT COUNT(*) AS c FROM books")
        if cur.fetchone()["c"] == 0:
            now = datetime.utcnow().isoformat()
            conn.executemany(
                "INSERT INTO books (title, author, year, created_at) VALUES (?,?,?,?)",
                [
                    ("El Quijote", "Miguel de Cervantes", 1605, now),
                    ("Cien años de soledad", "Gabriel García Márquez", 1967, now),
                    ("La sombra del viento", "Carlos Ruiz Zafón", 2001, now),
                ],
            )

@app.before_request
def _ensure_db():
    init_db()

# ---------- FRONT ----------
@app.get("/")
def front():
    return render_template("front.html")

@app.get("/api/books")
def api_list_books():
    q = request.args.get("q", "").strip()
    with get_db() as conn:
        if q:
            cur = conn.execute(
                "SELECT * FROM books WHERE title LIKE ? OR author LIKE ? ORDER BY id DESC",
                (f"%{q}%", f"%{q}%"),
            )
        else:
            cur = conn.execute("SELECT * FROM books ORDER BY id DESC")
        data = [dict(row) for row in cur.fetchall()]
    return jsonify(data)

@app.get("/api/books/<int:book_id>")
def api_get_book(book_id: int):
    with get_db() as conn:
        cur = conn.execute("SELECT * FROM books WHERE id = ?", (book_id,))
        row = cur.fetchone()
    if not row:
        abort(404)
    return jsonify(dict(row))

# ---------- ADMIN ----------
@app.get("/admin")
def admin():
    return render_template("admin.html")

@app.post("/api/admin/books")
def api_create_book():
    payload = request.get_json(force=True) or {}
    title = (payload.get("title") or "").strip()
    author = (payload.get("author") or "").strip()
    year = payload.get("year")

    if not title or not author:
        return jsonify({"error": "title y author son obligatorios"}), 400

    try:
        year_int = int(year) if year not in (None, "") else None
    except Exception:
        return jsonify({"error": "year debe ser numérico"}), 400

    with get_db() as conn:
        now = datetime.utcnow().isoformat()
        cur = conn.execute(
            "INSERT INTO books (title, author, year, created_at) VALUES (?,?,?,?)",
            (title, author, year_int, now),
        )
        conn.commit()
        return jsonify({"ok": True, "id": cur.lastrowid}), 201

@app.put("/api/admin/books/<int:book_id>")
def api_update_book(book_id: int):
    payload = request.get_json(force=True) or {}
    title = (payload.get("title") or "").strip()
    author = (payload.get("author") or "").strip()
    year = payload.get("year")

    if not title or not author:
        return jsonify({"error": "title y author son obligatorios"}), 400

    try:
        year_int = int(year) if year not in (None, "") else None
    except Exception:
        return jsonify({"error": "year debe ser numérico"}), 400

    with get_db() as conn:
        cur = conn.execute("SELECT id FROM books WHERE id = ?", (book_id,))
        if not cur.fetchone():
            return jsonify({"error": "no existe"}), 404

        conn.execute(
            "UPDATE books SET title=?, author=?, year=? WHERE id=?",
            (title, author, year_int, book_id),
        )
        conn.commit()
    return jsonify({"ok": True})

@app.delete("/api/admin/books/<int:book_id>")
def api_delete_book(book_id: int):
    with get_db() as conn:
        cur = conn.execute("SELECT id FROM books WHERE id = ?", (book_id,))
        if not cur.fetchone():
            return jsonify({"error": "no existe"}), 404
        conn.execute("DELETE FROM books WHERE id = ?", (book_id,))
        conn.commit()
    return jsonify({"ok": True})

# ---------- EXPORT / IMPORT ----------
@app.get("/api/admin/export")
def api_export_csv():
    with get_db() as conn:
        cur = conn.execute("SELECT id,title,author,year,created_at FROM books ORDER BY id ASC")
        rows = cur.fetchall()

    output = io.StringIO()
    w = csv.writer(output)
    w.writerow(["id", "title", "author", "year", "created_at"])
    for r in rows:
        w.writerow([r["id"], r["title"], r["author"], r["year"], r["created_at"]])

    mem = io.BytesIO(output.getvalue().encode("utf-8"))
    mem.seek(0)
    return send_file(mem, as_attachment=True, download_name="books_export.csv",
                     mimetype="text/csv; charset=utf-8")

@app.post("/api/admin/import")
def api_import_csv():
    if "file" not in request.files:
        return jsonify({"error": "Falta archivo en campo 'file'"}), 400
    f = request.files["file"]
    if not f.filename.lower().endswith(".csv"):
        return jsonify({"error": "Solo CSV"}), 400

    stream = io.StringIO(f.stream.read().decode("utf-8"))
    reader = csv.DictReader(stream)

    if not {"title", "author"}.issubset(set(reader.fieldnames or [])):
        return jsonify({"error": "El CSV debe contener: title, author (y opcional year)"}), 400

    now = datetime.utcnow().isoformat()
    to_insert = []
    for row in reader:
        title = (row.get("title") or "").strip()
        author = (row.get("author") or "").strip()
        year = (row.get("year") or "").strip()
        if not title or not author:
            continue
        try:
            year_int = int(year) if year else None
        except Exception:
            year_int = None
        to_insert.append((title, author, year_int, now))

    with get_db() as conn:
        conn.executemany(
            "INSERT INTO books (title, author, year, created_at) VALUES (?,?,?,?)",
            to_insert,
        )
        conn.commit()

    return jsonify({"ok": True, "imported": len(to_insert)})

if __name__ == "__main__":
    app.run(debug=True)

