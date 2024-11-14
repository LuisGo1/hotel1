<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conectar a la base de datos
include("../conecction/db.php");

// Paso 2: Procesar la solicitud AJAX para agregar una habitación
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tipo_habitacion'])) {
    $numero_habitacion = $_POST['numero_habitacion'];
    $tipo_habitacion = $_POST['tipo_habitacion'];
    $descripcion = $_POST['descripcion'];
    $capacidad = $_POST['capacidad'];
    $precio_noche = $_POST['precio_noche'];
    $estado = $_POST['estado'];
    $fecha_registro = $_POST['fecha_registro'];

    // Preparar la consulta SQL para insertar los datos
    $stmt = $conexion->prepare("INSERT INTO habitaciones (numero_habitacion, tipo_habitacion, descripcion, capacidad, precio_noche, estado, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issidss", $numero_habitacion, $tipo_habitacion, $descripcion, $capacidad, $precio_noche, $estado, $fecha_registro);

    // Ejecutar la consulta y devolver el resultado como JSON
    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "cuarto_id" => $conexion->insert_id,
            "numero_habitacion" => $numero_habitacion
        ]);
    } else {
        echo json_encode(["success" => false]);
    }

    $stmt->close();
    $conexion->close();
    exit(); // Salir del script para evitar que se ejecute el código HTML
}

include "../admin/includes/header.php"; // Continuar con el resto del código HTML
?>