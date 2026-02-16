Enunciado de la actividad (Python)

Módulo: Programación
Curso: 1º DAM
Evaluación: 2ª evaluación

Contexto

Vas a crear un programa en Python para gestionar sesiones fotográficas de una fotógrafa. El objetivo es practicar funciones, listas/diccionarios, control de errores y ficheros (contenidos típicos de la segunda evaluación).

Requisitos

1. El programa deberá permitir gestionar sesiones con estos datos mínimos:
-id (único)
-cliente
-fecha (texto en formato YYYY-MM-DD)
-tipo (familia, pareja, naturaleza, etc.)
-precio (número)

2. El programa tendrá un menú por consola con estas opciones:
-Añadir sesión
-Listar sesiones
-Buscar sesión por ID
-Calcular ingresos totales
-Guardar sesiones en un fichero (sesiones.json o sesiones.txt)
-Cargar sesiones desde el fichero
-Salir

3. Las sesiones se almacenarán en una lista de diccionarios.

Validaciones mínimas:
-No permitir IDs repetidos.
-Controlar que el precio sea un número válido y no negativo.
-Si se busca un ID que no existe, mostrar un mensaje adecuado.

Entrega
-Archivo .py con el programa.
-Fichero de ejemplo generado (sesiones.json o similar).
-Capturas o breve explicación de pruebas (opcional, si el profesor lo pide).
