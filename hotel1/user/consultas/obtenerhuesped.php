<?php
include "../../conecction/db.php";

if (!isset($_POST['id_habitacion']) || !is_numeric($_POST['id_habitacion'])) {
    echo json_encode(['success' => false, 'message' => 'Habitación ID no válido']);
    exit;
}

$id_habitacion = intval($_POST['id_habitacion']);

if (!$conexion) {
    echo json_encode(['success' => false, 'message' => 'No se pudo conectar a la base de datos']);
    exit;
}

$sql = "SELECT clt.nombre, clt.apellido, chk.fecha_check_in, chk.fecha_check_out 
        FROM check_in_out AS chk
        JOIN clientes AS clt ON chk.id_cliente = clt.cliente_id
        JOIN habitaciones AS hab ON chk.id_habitacion = hab.cuarto_id
        WHERE hab.cuarto_id = ?";
$stmt = $conexion->prepare($sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta', 'error' => $conexion->error]);
    exit;
}

$stmt->bind_param("i", $id_habitacion);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $habitaciones = [];

    if ($result->num_rows > 0) {
        while ($habitacion = $result->fetch_assoc()) {
            $habitaciones[] = $habitacion;
        }

        echo json_encode(['success' => true, 'habitaciones' => $habitaciones]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se encontraron datos']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Error en la ejecución de la consulta', 'error' => $stmt->error]);
}

$stmt->close();
$conexion->close();
?>

