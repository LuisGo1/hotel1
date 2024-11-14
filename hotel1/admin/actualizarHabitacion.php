<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar a la base de datos
include("../conecction/db.php");

if (isset($_POST['cuarto_id'])) {
    $cuarto_id = $_POST['cuarto_id'];
    $numero_habitacion = $_POST['numero_habitacion'];
    $tipo_habitacion = $_POST['tipo_habitacion'];
    $descripcion = $_POST['descripcion'];
    $capacidad = $_POST['capacidad'];
    $precio_noche = $_POST['precio_noche'];
    $estado = $_POST['estado'];
    $fecha_registro = $_POST['fecha_registro'];

    // Preparar la consulta SQL para actualizar los datos de la habitación
    $stmt = $conexion->prepare("UPDATE habitaciones SET numero_habitacion = ?, tipo_habitacion = ?, descripcion = ?, capacidad = ?, precio_noche = ?, estado = ?, fecha_registro = ? WHERE cuarto_id = ?");
    $stmt->bind_param("sssssssi", $numero_habitacion, $tipo_habitacion, $descripcion, $capacidad, $precio_noche, $estado, $fecha_registro, $cuarto_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "No se realizaron cambios."]);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(["success" => false, "message" => "Faltan parámetros."]);
}
?>