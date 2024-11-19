<?php
include("../conecction/db.php");

if (isset($_POST['numero_habitacion'])) {
    $numeroHabitacion = $_POST['numero_habitacion'];

    // Buscar el ID de la habitación por el número
    $consulta = $conexion->prepare("SELECT cuarto_id FROM habitaciones WHERE numero_habitacion = ?");
    $consulta->bind_param("s", $numeroHabitacion);
    $consulta->execute();
    $consulta->bind_result($cuarto_id);
    $consulta->fetch();
    $consulta->close();

    if ($cuarto_id) {
        echo json_encode(["success" => true, "id_habitacion" => $cuarto_id]);
    } else {
        echo json_encode(["success" => false, "message" => "Habitación no encontrada"]);
    }
}
?>
