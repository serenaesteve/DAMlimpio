<!doctype html>
<html>
  <head>
    <title>💿 Aplicación de gestión de discos</title>
  </head>
  <body>
    <h1>💿 Aplicación de gestión de discos</h1>
    <form action="insertadisco.php" method="POST">
      <input type="text" name="titulo" placeholder="Título del disco">
      <input type="text" name="artista" placeholder="Artista">
      <input type="number" name="anio" placeholder="Año de lanzamiento">
      <input type="text" name="genero" placeholder="Género musical">
      <input type="number" name="duracion_minutos" placeholder="Duración (min)">
      <input type="date" name="fecha_compra" placeholder="Fecha de compra">
      <input type="number" name="precio" step="0.01" placeholder="Precio">
      <input type="submit">
    </form>
    <?php include 'listardiscos.php'; ?>
  </body>
</html>
