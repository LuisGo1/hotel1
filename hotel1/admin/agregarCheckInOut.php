<?php
include("../conecction/db.php");

// Verificar que todos los campos se hayan enviado
if (isset($_POST['fecha_check_in'], $_POST['fecha_check_out'], $_POST['id_reserva'], $_POST['id_cliente'], $_POST['estado'], $_POST['id_habitacion'], $_POST['cant_dias'], $_POST['id_empleado'])) {
    $fecha_check_in = $_POST['fecha_check_in'];
    $fecha_check_out = $_POST['fecha_check_out'];
    $id_reserva = $_POST['id_reserva'];
    $id_cliente = $_POST['id_cliente'];
    $estado = $_POST['estado'];
    $id_habitacion = $_POST['id_habitacion'];
    $cant_dias = $_POST['cant_dias'];
    $id_empleado = $_POST['id_empleado'];

    // Preparar la consulta de inserción
    $stmt = $conexion->prepare("INSERT INTO check_in_out (fecha_check_in, fecha_check_out, id_reserva, id_cliente, estado, id_habitacion, cant_dias, id_empleado) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissiii", $fecha_check_in, $fecha_check_out, $id_reserva, $id_cliente, $estado, $id_habitacion, $cant_dias, $id_empleado);

    if ($stmt->execute()) {
        // Retornar el check_id insertado para actualizar la tabla dinámicamente
        $check_id = $stmt->insert_id;
        echo json_encode(["success" => true, "check_id" => $check_id]);
    } else {
        echo json_encode(["success" => false, "message" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Datos incompletos"]);
}

$conexion->close();
?>
