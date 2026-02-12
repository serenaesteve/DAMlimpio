<?php
<?php
$mysqli = new mysqli("localhost", "root", "", "miempresa");
	if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}
?>
if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}
?>
<!doctype html>
<html>
<head>
  <style>
    html, body { width: 100%; height: 100%; padding: 0px; margin: 0px; font-family: sans-serif; }
    body { display: flex; }
    nav { flex: 1; background: indigo; color: white; padding: 20px; display: flex; flex-direction: column; gap: 20px; }
    main { flex: 5; background: aliceblue; padding: 20px; }
    nav a { border: none; background: white; padding: 20px; text-decoration: none; color: indigo; text-transform: uppercase; font-weight: bold; border-radius: 5px; }
  </style>
</head>
<body>
  <nav>
    <?php
      $sql = "SHOW TABLES";
      $resultado = $mysqli->query($sql);
      while ($fila = $resultado->fetch_assoc()) {
        echo '<a href="?tabla=' . urlencode($fila['Tables_in_miempresa']) . '">' . htmlspecialchars($fila['Tables_in_miempresa']) . '</a>';
      }
    ?>
  </nav>
  <main>
    <?php
      if (isset($_GET['tabla'])) {
        $sql = "SELECT * FROM " . $_GET['tabla'] . ";";
        $resultado = $mysqli->query($sql);
        if ($resultado->num_rows > 0) {
          echo "<table class='redondeado'>";
          echo "<thead>";
          while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            foreach ($fila as $clave => $valor) {
              echo "<th>" . htmlspecialchars($clave) . "</th>";
            }
            echo "</tr>";
            break;
          }
          echo "</thead>";
          echo "<tbody>";
          while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            foreach ($fila as $valor) {
              echo "<td>" . htmlspecialchars($valor) . "</td>";
            }
            echo "</tr>";
          }
          echo "</tbody>";
          echo "</table>";
        } else {
          echo "No hay datos en la tabla seleccionada.";
        }
      } else {
        echo "Selecciona una tabla para ver sus datos.";
      }
    ?>
  </main>
</body>
</html>
