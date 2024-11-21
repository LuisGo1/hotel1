<?php
include "../../conecction/db.php";

$data = json_decode(file_get_contents("php://input"));

if (isset($data->id_habitacion) && isset($data->nuevo_estado)) {
    $id_habitacion = $data->id_habitacion; 
    $nuevo_estado = $data->nuevo_estado;    

    $sql = "UPDATE habitaciones SET estado = ? WHERE cuarto_id = ?";

    if ($stmt = $conexion->prepare($sql)) {
        $stmt->bind_param('si', $nuevo_estado, $id_habitacion);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el estado de la habitación.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos.']);
}

$conexion->close();
?>
