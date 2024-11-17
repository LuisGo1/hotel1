<?php
session_start();
include("../conecction/db.php"); // Conexión a la base de datos

// Verificar si el usuario está logueado
if (!isset($_SESSION['empleado_id'])) {
    echo json_encode(['success' => false, 'error' => 'No autorizado.']);
    exit();
}

// Verificar la conexión a la base de datos
if (!$conexion) {
    echo json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos.']);
    exit();
}

// Obtener los datos de la tabla caja_diaria
$query = "SELECT * FROM caja_diaria WHERE empleado_id = ? ORDER BY fecha_apertura DESC";
$stmt = $conexion->prepare($query);

// Verificar si la preparación de la consulta fue exitosa
if ($stmt === false) {
    echo json_encode(['success' => false, 'error' => 'Error al preparar la consulta.']);
    exit();
}

$stmt->bind_param("i", $_SESSION['empleado_id']);
$stmt->execute();
$result = $stmt->get_result();

$cajas = [];
while ($row = $result->fetch_assoc()) {
    $cajas[] = $row;  // Almacena los resultados en un array
}

// Verificar si hay resultados
if (!empty($cajas)) {
    echo json_encode(['success' => true, 'data' => $cajas]);
} else {
    echo json_encode(['success' => false, 'error' => 'No se encontraron cajas.']);
}

// Cerrar la consulta y la conexión
$stmt->close();
$conexion->close();
?>
