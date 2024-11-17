<?php
include("../conecction/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID de la reserva que se quiere eliminar
    $reserva_id = $_POST['reserva_id'];

    // Verificar que la ID no esté vacía
    if (!empty($reserva_id)) {
        // Preparar la consulta de eliminación
        $stmt = $conexion->prepare("DELETE FROM reservas WHERE reserva_id = ?");
        $stmt->bind_param("i", $reserva_id);

        // Ejecutar la consulta y verificar si fue exitosa
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'No se pudo eliminar la reserva']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'ID de reserva no proporcionado']);
    }

    $conexion->close();
}
?>
