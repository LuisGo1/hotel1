<?php
include "../../conecction/db.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $cliente_id = $_GET['id'];

    $query = "DELETE FROM clientes WHERE cliente_id = ?";
    $stmt = mysqli_prepare($conexion, $query);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);

    if (mysqli_stmt_execute($stmt)) {
        header('Location: ../../admin/clientes.php?m=1');
    } else {
        echo "Error al eliminar el cliente.";
    }
    mysqli_stmt_close($stmt);
}
