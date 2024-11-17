<?php
session_start();
include("../conecction/db.php");

// Verificar que el usuario esté logueado (opcional)
if (!isset($_SESSION['empleado_id'])) {
    echo json_encode(['success' => false, 'error' => 'No autorizado.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['fecha']) && isset($_POST['monto']) && isset($_POST['empleado_id'])) {
        $fecha = $_POST['fecha'];
        $monto = $_POST['monto'];
        $empleado_id = $_POST['empleado_id'];

        // Preparamos la consulta para insertar en la tabla caja_diaria
        $query = "INSERT INTO caja_diaria (fecha_apertura, monto_apertura, empleado_id) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($query);

        // Enlazamos los parámetros
        // 's' para string (fecha), 'd' para double (monto), 'i' para integer (empleado_id)
        $stmt->bind_param("sdi", $fecha, $monto, $empleado_id);

        // Ejecutamos la consulta
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Caja abierta correctamente.']);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error al abrir la caja.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Faltan datos en el formulario.']);
    }
}

$conexion->close();
?>
