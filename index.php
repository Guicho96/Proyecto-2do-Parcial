<?php
$servername = "localhost";
$username = "usuario";
$password = "";
$database = "proyecto-2do-parcial";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
echo "¡Conexión exitosa!";
?>
