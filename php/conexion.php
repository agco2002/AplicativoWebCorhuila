<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "corhuila";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("Conexión fallida: " . $conn->connect_error);
    die("Conexión fallida: " . $conn->connect_error);
}

error_log("Conexión a la base de datos establecida correctamente");
?>