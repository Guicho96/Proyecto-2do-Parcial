<?php

$servidor = "Localhost";
$user= "root";
$pass= "";
$bd= "ubicaciones";

$conexion = mysqli_connect($servidor, $user, $pass, $bd);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
} else {
   echo "Conexión exitosa";
}   


?>