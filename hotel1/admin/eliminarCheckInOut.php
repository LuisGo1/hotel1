<?php
include("../conecction/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $check_id = $_POST['check_id'];

    if ($check_id) {
        $stmt = $conexion->prepare("DELETE FROM check_in_out WHERE check_id = ?");
        $stmt->bind_param("i", $check_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al eliminar el registro."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "ID inválido."]);
    }

    $conexion->close();
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
?>
