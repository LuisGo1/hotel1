<?php
include "../../conecction/db.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8'); 

try {
    // Validar conexión
    if (!$conexion) {
        throw new Exception("Error en la conexión a la base de datos.");
    }

    $busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';

    if ($busqueda) {
        $sql = "SELECT * FROM `clientes` WHERE nombre_cliente LIKE '%$busqueda%' OR apellido_cliente LIKE '%$busqueda%'";
    } else {
        $sql = "SELECT * FROM `clientes`";
    }

    $result = $conexion->query($sql);

    if (!$result) {
        throw new Exception("Error al ejecutar la consulta: " . $conexion->error);
    }

    $clientes = [];
    while ($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }

    echo json_encode([
        'success' => true,
        'clientes' => $clientes
    ]);
} catch (Exception $e) {
    
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
} finally {
    if (isset($result)) $result->free();
    $conexion->close();
}
