<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("../conecction/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibimos los datos enviados desde AJAX
    $id_cliente = $_POST['clienteid'];
    $cuarto_id = $_POST['cuartoid'];
    $num_huespedes = $_POST['numerohuespedes'];
    $comentarios = $_POST['comentarios'];
    $estado = $_POST['estado'];
    $monto_total = $_POST['montototal'];
    $fecha_registro = $_POST['fecha'];

    // Validar que el cuarto existe
    $consultaCuarto = $conexion->prepare("SELECT COUNT(*) FROM habitaciones WHERE cuarto_id = ?");
    $consultaCuarto->bind_param("i", $cuarto_id);
    $consultaCuarto->execute();
    $consultaCuarto->bind_result($cuartoExiste);
    $consultaCuarto->fetch();
    $consultaCuarto->close();

    if (!$cuartoExiste) {
        // Si el cuarto no existe, devolvemos un error
        echo json_encode(["error" => "Introduzca un cuarto existente"]);
        exit;
    }

    // Preparamos la consulta para insertar la reserva
    $stmt = $conexion->prepare("INSERT INTO reservas (id_cliente, cuarto_id, num_huespedes, comentarios, estado, monto_total, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiissds", $id_cliente, $cuarto_id, $num_huespedes, $comentarios, $estado, $monto_total, $fecha_registro);

    if ($stmt->execute()) {
        // Si la inserción es exitosa, devolvemos los datos de la nueva reserva en formato JSON
        echo json_encode([
            "reserva_id" => $stmt->insert_id,
            "id_cliente" => $id_cliente,
            "cuarto_id" => $cuarto_id,
            "num_huespedes" => $num_huespedes,
            "comentarios" => $comentarios,
            "estado" => $estado,
            "monto_total" => $monto_total,
            "fecha_registro" => $fecha_registro
        ]);
    } else {
        // En caso de error, devolvemos un mensaje de error
        echo json_encode(["error" => "No se pudo agregar la reserva"]);
    }

    $stmt->close();
    $conexion->close();
}
?>
