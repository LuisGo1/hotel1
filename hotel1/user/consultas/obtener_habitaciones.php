<?php
include "../../conecction/db.php";

if (isset($_POST['nivel_id'])) {
    $nivelId = $_POST['nivel_id'];

    $sql = "SELECT * FROM habitaciones WHERE id_nivel = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $nivelId);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        $habitaciones = [];

        if ($result->num_rows > 0) {
            while ($habitacion = $result->fetch_assoc()) {
                $habitaciones[] = $habitacion;
            }

            echo json_encode(['success' => true, 'habitaciones' => $habitaciones]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontraron habitaciones']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Error en la consulta']);
    }
    
    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Nivel ID no recibido']);
}
?>

