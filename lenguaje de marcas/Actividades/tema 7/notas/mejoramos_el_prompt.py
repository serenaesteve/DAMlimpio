import sys
import csv
import json
import requests
from collections import defaultdict


URL = "http://localhost:11434/api/generate"

MODEL = "llama3:latest"

CSV_PATH = "respuestas.csv"

OLLAMA_OPTIONS = {
    "temperature": 0.0,
    "top_p": 1.0,
    "num_ctx": 4096,
}


ANSWER_KEY = {
    "PHP es un lenguaje de:": "Servidor",
    "Javascript es un lenguaje de": "Cliente",
    "CSS es un lenguaje de": "Estilo",
    "HTML es un lenguaje de": "Marcas",
    "IF es:": "Estructura condicional",
    "While es una estructura de:": "Bucle",
}


def compute_scores_base10(csv_path: str, answer_key: dict) -> dict:
    stats = defaultdict(lambda: {"aciertos": 0, "fallos": 0, "sin_clave": 0})

    with open(csv_path, "r", encoding="utf-8", newline="") as f:
        reader = csv.reader(f)
        for row in reader:
            if not row or len(row) < 3:
                continue

            name = (row[0] or "").strip()
            question = (row[1] or "").strip()
            answer = (row[2] or "").strip()

            
            if name == "":
                continue

            if question not in answer_key:
                stats[name]["sin_clave"] += 1
                continue

            expected = answer_key[question]
            if answer == expected:
                stats[name]["aciertos"] += 1
            else:
                stats[name]["fallos"] += 1

    
    results = {}
    for name, s in stats.items():
        total_con_clave = s["aciertos"] + s["fallos"]
        nota10 = None if total_con_clave <= 0 else (s["aciertos"] / total_con_clave) * 10.0
        results[name] = {
            **s,
            "total_con_clave": total_con_clave,
            "nota_sobre_10": nota10,
        }
    return results


def render_console_table(scores: dict) -> str:
    
    def sort_key(item):
        name, s = item
        nota = s["nota_sobre_10"]
        return (-(nota if nota is not None else -1e9), name)

    rows = []
    for name, s in sorted(scores.items(), key=sort_key):
        nota = s["nota_sobre_10"]
        nota_str = "N/A" if nota is None else f"{nota:.2f}"
        rows.append([
            name,
            str(s["aciertos"]),
            str(s["fallos"]),
            str(s["sin_clave"]),
            str(s["total_con_clave"]),
            nota_str,
        ])

    headers = ["Alumno", "OK", "FAIL", "SIN_CLAVE", "TOTAL_CLAVE", "NOTA/10"]

    cols = list(zip(headers, *rows)) if rows else [headers]
    widths = [max(len(str(cell)) for cell in col) for col in cols]

    def fmt_row(r):
        return " | ".join(str(cell).ljust(widths[i]) for i, cell in enumerate(r))

    sep = "-+-".join("-" * w for w in widths)

    out = []
    out.append(fmt_row(headers))
    out.append(sep)
    for r in rows:
        out.append(fmt_row(r))
    return "\n".join(out)



def build_truth_by_student(csv_path: str, answer_key: dict) -> dict:
    per_student = defaultdict(list)

    with open(csv_path, "r", encoding="utf-8", newline="") as f:
        reader = csv.reader(f)
        for row in reader:
            if not row or len(row) < 3:
                continue

            name = (row[0] or "").strip()
            question = (row[1] or "").strip()
            answer = (row[2] or "").strip()
            options_json = row[3] if len(row) > 3 else ""

           
            if name == "":
                continue

            if question not in answer_key:
                verdict = "SIN_CLAVE"
                expected = None
            else:
                expected = answer_key[question]
                verdict = "OK" if answer == expected else "FAIL"

            per_student[name].append({
                "pregunta": question,
                "respuesta": answer,
                "veredicto": verdict,
                "esperada": expected,
                "opciones_json": options_json,
            })

    return per_student



try:
    with open(CSV_PATH, "r", encoding="utf-8") as f:
        csv_raw = f.read()
except FileNotFoundError:
    print(f"ERROR: No existe el archivo: {CSV_PATH}", file=sys.stderr)
    sys.exit(1)

scores = compute_scores_base10(CSV_PATH, ANSWER_KEY)
table_txt = render_console_table(scores)

truth = build_truth_by_student(CSV_PATH, ANSWER_KEY)
truth_json = json.dumps(truth, ensure_ascii=False, indent=2)


prompt = f"""
Eres un generador de INFORMES. NO corrige ni decide veredictos.
Recibirás un JSON que YA contiene la corrección hecha por Python.

REGLAS:
1) NO cambies los veredictos.
2) NO inventes preguntas ni errores.
3) Formato estilo terminal Linux, monoespaciado, claro.
4) Por alumno:
   - Lista cada entrada con: Pregunta, Respuesta, Veredicto, y si hay, Esperada.
   - Al final del alumno: resumen (OK/FAIL/SIN_CLAVE).
5) Incluye un resumen final global con ranking por NOTA/10 si está disponible.

Tabla de notas (verdad):
{table_txt}

Datos detallados (verdad) en JSON:
{truth_json}
"""

payload = {
    "model": MODEL,
    "prompt": prompt,
    "stream": False,
    "options": OLLAMA_OPTIONS,
}

report = None
try:
    response = requests.post(URL, json=payload, timeout=120)
    data = response.json()
    report = data.get("response")
    if not report:
        raise RuntimeError(str(data))
except Exception as e:
    print("\n[AVISO] No se pudo generar informe con Ollama. Se mostrará solo la tabla.")
    print(f"[DETALLE] {e}\n")
    report = None


print()
print("=== TABLA DE NOTAS (0..10) ===")
print(table_txt)
print()

if report:
    print("=== INFORME DETALLADO ===")
    print(report)
else:
    print("=== INFORME DETALLADO ===")
    print("(No disponible: Ollama no respondió con 'response')")

