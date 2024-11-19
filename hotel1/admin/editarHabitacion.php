<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar a la base de datos
include("../conecction/db.php");

if (isset($_GET['cuarto_id'])) {
    $cuarto_id = $_GET['cuarto_id'];

    // Preparar la consulta SQL para obtener los datos de la habitación
    $stmt = $conexion->prepare("SELECT cuarto_id, numero_habitacion, tipo_habitacion, descripcion, capacidad, precio_noche, estado, fecha_registro, id_nivel FROM habitaciones WHERE cuarto_id = ?");
    $stmt->bind_param("i", $cuarto_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Devolver los datos como JSON
        $habitacion = $result->fetch_assoc();
        echo json_encode(["success" => true, "data" => $habitacion]);
    } else {
        echo json_encode(["success" => false, "message" => "Habitación no encontrada."]);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(["success" => false, "message" => "ID de habitación no proporcionado."]);
}
?>