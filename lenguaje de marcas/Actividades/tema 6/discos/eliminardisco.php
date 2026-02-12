<?php
if(isset($_GET['id'])){
    $mysqli = new mysqli("localhost", "discos", "discos", "discos");

    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $sql = "DELETE FROM discos WHERE id = " . intval($_GET['id']);

    if ($mysqli->query($sql) === TRUE) {
        echo "Disco eliminado con éxito";
    } else {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }

    $mysqli->close();
}
?>
