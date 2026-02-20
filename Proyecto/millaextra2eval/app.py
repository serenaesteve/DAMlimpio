from flask import Flask, render_template, request, redirect, url_for, flash
import sqlite3
from datetime import date

app = Flask(__name__)
app.secret_key = "dam_biblioteca_secret"  # para flash messages

DB_NAME = "biblioteca.db"


def get_conn():
    conn = sqlite3.connect(DB_NAME)
    conn.row_factory = sqlite3.Row
    return conn


def init_db():
    conn = get_conn()
    cur = conn.cursor()

    cur.execute("""
    CREATE TABLE IF NOT EXISTS libros (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        titulo TEXT NOT NULL,
        autor TEXT NOT NULL,
        anio INTEGER NOT NULL
    );
    """)

    cur.execute("""
    CREATE TABLE IF NOT EXISTS prestamos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        libro_id INTEGER NOT NULL,
        prestatario TEXT NOT NULL,
        fecha_prestamo TEXT NOT NULL,
        fecha_devolucion TEXT,
        devuelto INTEGER NOT NULL DEFAULT 0,
        FOREIGN KEY (libro_id) REFERENCES libros(id)
            ON UPDATE CASCADE
            ON DELETE RESTRICT
    );
    """)

    conn.commit()
    conn.close()


@app.route("/")
def home():
    return redirect(url_for("libros"))


# -----------------------
# LIBROS
# -----------------------
@app.route("/libros", methods=["GET", "POST"])
def libros():
    if request.method == "POST":
        titulo = request.form.get("titulo", "").strip()
        autor = request.form.get("autor", "").strip()
        anio = request.form.get("anio", "").strip()

        if not titulo or not autor or not anio:
            flash("Rellena título, autor y año.", "error")
            return redirect(url_for("libros"))

        try:
            anio_int = int(anio)
        except ValueError:
            flash("El año debe ser un número.", "error")
            return redirect(url_for("libros"))

        conn = get_conn()
        cur = conn.cursor()
        cur.execute("INSERT INTO libros (titulo, autor, anio) VALUES (?, ?, ?)",
                    (titulo, autor, anio_int))
        conn.commit()
        conn.close()

        flash("Libro añadido correctamente.", "ok")
        return redirect(url_for("libros"))

    conn = get_conn()
    libros_list = conn.execute("SELECT * FROM libros ORDER BY id DESC").fetchall()
    conn.close()
    return render_template("libros.html", libros=libros_list)


# -----------------------
# PRÉSTAMOS
# -----------------------
@app.route("/prestamos", methods=["GET", "POST"])
def prestamos():
    conn = get_conn()

    if request.method == "POST":
        libro_id = request.form.get("libro_id", "").strip()
        prestatario = request.form.get("prestatario", "").strip()
        fecha_prestamo = request.form.get("fecha_prestamo", "").strip()
        fecha_devolucion = request.form.get("fecha_devolucion", "").strip()

        if not libro_id or not prestatario or not fecha_prestamo:
            flash("Rellena libro, prestatario y fecha de préstamo.", "error")
            conn.close()
            return redirect(url_for("prestamos"))

        # fecha_devolucion puede estar vacía
        if fecha_devolucion == "":
            fecha_devolucion = None

        try:
            libro_id_int = int(libro_id)
        except ValueError:
            flash("Libro inválido.", "error")
            conn.close()
            return redirect(url_for("prestamos"))

        # Comprobar que el libro existe
        libro = conn.execute("SELECT id FROM libros WHERE id = ?", (libro_id_int,)).fetchone()
        if not libro:
            flash("Ese libro no existe.", "error")
            conn.close()
            return redirect(url_for("prestamos"))

        # (Opcional) Evitar prestar un libro que ya está prestado sin devolver
        abierto = conn.execute("""
            SELECT id FROM prestamos
            WHERE libro_id = ? AND devuelto = 0
        """, (libro_id_int,)).fetchone()
        if abierto:
            flash("Ese libro ya está prestado y no se ha devuelto.", "error")
            conn.close()
            return redirect(url_for("prestamos"))

        conn.execute("""
            INSERT INTO prestamos (libro_id, prestatario, fecha_prestamo, fecha_devolucion, devuelto)
            VALUES (?, ?, ?, ?, 0)
        """, (libro_id_int, prestatario, fecha_prestamo, fecha_devolucion))
        conn.commit()
        conn.close()

        flash("Préstamo registrado.", "ok")
        return redirect(url_for("prestamos"))

    # GET: listar
    libros_list = conn.execute("SELECT * FROM libros ORDER BY titulo ASC").fetchall()
    prestamos_list = conn.execute("""
        SELECT p.*, l.titulo, l.autor
        FROM prestamos p
        JOIN libros l ON l.id = p.libro_id
        ORDER BY p.id DESC
    """).fetchall()
    conn.close()

    return render_template("prestamos.html", libros=libros_list, prestamos=prestamos_list, hoy=str(date.today()))


@app.post("/prestamos/<int:prestamo_id>/devolver")
def devolver_prestamo(prestamo_id: int):
    conn = get_conn()
    p = conn.execute("SELECT id, devuelto FROM prestamos WHERE id = ?", (prestamo_id,)).fetchone()
    if not p:
        conn.close()
        flash("Préstamo no encontrado.", "error")
        return redirect(url_for("prestamos"))

    if p["devuelto"] == 1:
        conn.close()
        flash("Ese préstamo ya estaba devuelto.", "error")
        return redirect(url_for("prestamos"))

    conn.execute("""
        UPDATE prestamos
        SET devuelto = 1,
            fecha_devolucion = COALESCE(fecha_devolucion, ?)
        WHERE id = ?
    """, (str(date.today()), prestamo_id))
    conn.commit()
    conn.close()

    flash("Préstamo marcado como devuelto.", "ok")
    return redirect(url_for("prestamos"))


if __name__ == "__main__":
    init_db()
    app.run(debug=True)
