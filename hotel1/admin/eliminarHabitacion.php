<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar a la base de datos
include("../conecction/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cuarto_id'])) {
    $cuarto_id = $_POST['cuarto_id'];

    // Verificar si se ha recibido el ID
    if (empty($cuarto_id)) {
        echo json_encode(["success" => false, "message" => "ID de habitación no proporcionado."]);
        exit();
    }

    // Preparar la consulta SQL para eliminar la habitación
    $stmt = $conexion->prepare("DELETE FROM habitaciones WHERE cuarto_id = ?");
    if ($stmt === false) {
        echo json_encode(["success" => false, "message" => "Error en la preparación de la consulta SQL."]);
        exit();
    }

    $stmt->bind_param("i", $cuarto_id);

    // Ejecutar la consulta y devolver el resultado como JSON
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al ejecutar la consulta."]);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido o datos no completos."]);
}
?>