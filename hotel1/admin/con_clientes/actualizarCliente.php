<?php
include "../../conecction/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'editar') {
    $clienteId = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $comentarios = $_POST['comentarios'];

    $query = "UPDATE clientes SET nombre_cliente = ?, apellido_client = ?, telefono = ?, email = ?, direccion = ?, comentarios = ? WHERE cliente_id = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $nombre, $apellido, $telefono, $email, $direccion, $comentarios, $clienteId);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Error al actualizar el cliente."]);
    }
    mysqli_stmt_close($stmt);
}