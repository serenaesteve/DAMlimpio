<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Archivo</title>
</head>
<body>
    <h1>Subir archivo a la base de datos</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        <br><br>
        <label for="archivo">Selecciona un archivo:</label>
        <input type="file" name="archivo" id="archivo" required>
        <br><br>
        <input type="submit" value="Subir archivo">
    </form>
</body>
</html>

