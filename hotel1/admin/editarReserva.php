<?php
include("../conecction/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos enviados
    $reserva_id = $_POST['reserva_id'];
    $id_cliente = $_POST['clienteid'];
    $cuarto_id = $_POST['cuartoid'];
    $num_huespedes = $_POST['numerohuespedes'];
    $comentarios = $_POST['comentarios'];
    $estado = $_POST['estado'];
    $monto_total = $_POST['montototal'];
    $fecha_registro = $_POST['fecha'];

    // Verificar que todos los campos requeridos estén presentes
    if (!empty($reserva_id) && !empty($id_cliente) && !empty($cuarto_id) && !empty($num_huespedes) && !empty($estado) && !empty($monto_total) && !empty($fecha_registro)) {
        // Preparar la consulta de actualización
        $stmt = $conexion->prepare("UPDATE reservas SET id_cliente=?, cuarto_id=?, num_huespedes=?, comentarios=?, estado=?, monto_total=?, fecha_registro=? WHERE reserva_id=?");
        $stmt->bind_param("iiissisi", $id_cliente, $cuarto_id, $num_huespedes, $comentarios, $estado, $monto_total, $fecha_registro, $reserva_id);

        // Ejecutar la consulta y verificar si fue exitosa
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo actualizar la reserva']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Faltan campos requeridos']);
    }

    $conexion->close();
}
?>
