<?php
include("../conecction/db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $checkId = $_POST["check_id"];
    $fechaCheckIn = $_POST["fecha_check_in"];
    $fechaCheckOut = $_POST["fecha_check_out"];
    $idReserva = $_POST["id_reserva"];
    $idCliente = $_POST["id_cliente"];
    $estado = $_POST["estado"];
    $idHabitacion = $_POST["id_habitacion"];
    $cantDias = $_POST["cant_dias"];
    $idEmpleado = $_POST["id_empleado"];

    $sql = "UPDATE check_in_out 
            SET fecha_check_in = ?, 
                fecha_check_out = ?, 
                id_reserva = ?, 
                id_cliente = ?, 
                estado = ?, 
                id_habitacion = ?, 
                cant_dias = ?, 
                id_empleado = ?
            WHERE check_id = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ssiisiiii", $fechaCheckIn, $fechaCheckOut, $idReserva, $idCliente, $estado, $idHabitacion, $cantDias, $idEmpleado, $checkId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Error en la base de datos: " . $stmt->error]);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
}
?>
