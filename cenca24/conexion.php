<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "seciit";

// Crear conexion
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexion
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}
