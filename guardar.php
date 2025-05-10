<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

$response = ['success' => false, 'message' => ''];

// Configuración de la base de datos (ajusta según tu configuración de Laragon)
$servername = "localhost";
$username = "root";  // Usuario por defecto en Laragon
$password = "";      // Contraseña por defecto en Laragon
$dbname = "proyecto-2do-parcial";

try {
    // Crear conexión
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtener datos del POST (formulario)
    $data = json_decode(file_get_contents('php://input'), true);

    // Validar datos básicos
    if (empty($data['nombres']) || empty($data['apellidoP']) || empty($data['correo']) || empty($data['telefono'])) {
        throw new Exception("Datos personales incompletos");
    }

    // Preparar consulta SQL
    $sql = "INSERT INTO registros2 (
        nombres, 
        apellido_paterno, 
        apellido_materno, 
        correo, 
        telefono,
        calle,
        numero,
        colonia,
        municipio,
        estado,
        codigo_postal,
        latitud,
        longitud
    ) VALUES (
        :nombres, 
        :apellidoP, 
        :apellidoM, 
        :correo, 
        :telefono,
        :calle,
        :numero,
        :colonia,
        :municipio,
        :estado,
        :cp,
        :latitud,
        :longitud
    )";

    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':nombres', $data['nombres']);
    $stmt->bindParam(':apellidoP', $data['apellidoP']);
    $stmt->bindParam(':apellidoM', $data['apellidoM']);
    $stmt->bindParam(':correo', $data['correo']);
    $stmt->bindParam(':telefono', $data['telefono']);
    $stmt->bindParam(':calle', $data['direccion']['calle']);
    $stmt->bindParam(':numero', $data['direccion']['numero']);
    $stmt->bindParam(':colonia', $data['direccion']['colonia']);
    $stmt->bindParam(':municipio', $data['direccion']['municipio']);
    $stmt->bindParam(':estado', $data['direccion']['estado']);
    $stmt->bindParam(':cp', $data['direccion']['cp']);
    $stmt->bindParam(':latitud', $data['direccion']['coordenadas']['latitud']);
    $stmt->bindParam(':longitud', $data['direccion']['coordenadas']['longitud']);

    // Ejecutar consulta
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Registro guardado correctamente";
    } else {
        $response['message'] = "Error al guardar el registro";
    }
} catch(PDOException $e) {
    $response['message'] = "Error de base de datos: " . $e->getMessage();
} catch(Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>