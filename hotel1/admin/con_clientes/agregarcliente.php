<?php
include "../../conecction/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'agregar') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $comentarios = $_POST['comentarios'];

    $query = "INSERT INTO clientes (nombre_cliente, apellido_client, telefono, email, direccion, comentarios)
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "ssssss", $nombre, $apellido, $telefono, $email, $direccion, $comentarios);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Error al guardar el cliente."]);
    }
    mysqli_stmt_close($stmt);
}
