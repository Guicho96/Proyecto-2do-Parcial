<?php
// Conexión a la base de datos (ajusta con tus credenciales)
$conexion = new mysqli("localhost", "usuario", "contraseña", "nombre_de_base_de_datos");

// Verifica la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recoger datos del formulario
$nombre = $_POST['nombre'];
$apellido_paterno = $_POST['apellido_paterno'];
$apellido_materno = $_POST['apellido_materno'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];

// Insertar en la base de datos
$sql = "INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, correo, telefono) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssss", $nombre, $apellido_paterno, $apellido_materno, $correo, $telefono);

if ($stmt->execute()) {
    echo "Registro guardado correctamente.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
