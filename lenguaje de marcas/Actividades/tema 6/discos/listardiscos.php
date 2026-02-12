<?php
$mysqli = new mysqli("localhost", "discos", "discos", "discos");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql = "SELECT * FROM discos";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Título</th><th>Artista</th><th>Año</th><th>Género</th><th>Duración (min)</th><th>Fecha de compra</th><th>Precio</th></tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["titulo"] . "</td>";
        echo "<td>" . $row["artista"] . "</td>";
        echo "<td>" . $row["anio"] . "</td>";
        echo "<td>" . $row["genero"] . "</td>";
        echo "<td>" . $row["duracion_minutos"] . "</td>";
        echo "<td>" . $row["fecha_compra"] . "</td>";
        echo "<td>" . $row["precio"] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$mysqli->close();
?>
