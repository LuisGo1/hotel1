<?php
include "../../conecction/db.php";

// Verificar la conexión
if (!$conexion) {
    die("Error en la conexión a la base de datos: " . mysqli_connect_error());
}

// Verificar datos recibidos
var_dump($_POST); // O $_GET en caso de que uses GET
die(); // Para detener la ejecución aquí y ver los resultados

if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['telefono']) && isset($_POST['correo']) && isset($_POST['direccion']) && isset($_POST['comentarios'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $comentarios = $_POST['comentarios'];

    $query = "UPDATE clientes SET nombre_cliente = ?, apellido_client = ?, telefono = ?, email = ?, direccion = ?, comentarios = ? WHERE cliente_id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssssssi", $nombre, $apellido, $telefono, $correo, $direccion, $comentarios, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Error al actualizar el cliente"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "Datos incompletos para actualizar el cliente"]);
}

$conexion->close();
?>
