<?php
// eliminarempleado.php

include("../../conecction/db.php");


if (isset($_GET['id'])) {
    $empleado_id = $_GET['id'];

    // Prepare and execute the delete query securely
    $query = "DELETE FROM caja_diaria WHERE caja_id = ?";
    if ($stmt = mysqli_prepare($conexion, $query)) {
        mysqli_stmt_bind_param($stmt, 'i', $empleado_id); // 'i' means integer
        if (mysqli_stmt_execute($stmt)) {
            header('Location: ../../admin/caja.php?m=1');
        } else {
            echo "Error al eliminar el empleado";
        }
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conexion);
?>
