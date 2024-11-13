<?php
include "../../conecction/db.php";

// Verificar la conexión
if (!$conexion) {
    die("Error en la conexión a la base de datos: " . mysqli_connect_error());
}

// Verificar datos recibidos
var_dump($_POST); // O $_GET en caso de que uses GET
die(); // Para detener la ejecución aquí y ver los resultados

if (isset($_POST['id'])) {
    $clienteId = $_POST['id'];
    $query = "DELETE FROM clientes WHERE cliente_id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $clienteId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Error al eliminar el cliente"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "ID de cliente no recibido para eliminar"]);
}

$conexion->close();
?>
