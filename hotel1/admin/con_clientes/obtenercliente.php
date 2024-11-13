<?php
include "../../conecction/db.php";

// Verificar la conexión
if (!$conexion) {
    die("Error en la conexión a la base de datos: " . mysqli_connect_error());
}

// Verificar datos recibidos
var_dump($_POST); // O $_GET en caso de que uses GET
die(); // Para detener la ejecución aquí y ver los resultados

if (isset($_GET['id'])) {
    $clienteId = $_GET['id'];
    $query = "SELECT * FROM clientes WHERE cliente_id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $clienteId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($cliente = $result->fetch_assoc()) {
        echo json_encode($cliente);
    } else {
        echo json_encode(["error" => "Cliente no encontrado"]);
    }

    $stmt->close();
} else {
    echo json_encode(["error" => "ID de cliente no recibido"]);
}

$conexion->close();
?>
