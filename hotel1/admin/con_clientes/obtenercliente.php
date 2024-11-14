<?php
include "../../conecction/db.php";

if (isset($_GET['id'])) {
    $empleadoId = $_GET['id'];

    $query = "SELECT * FROM clientes WHERE cliente_id = ?";
    
    
    if ($stmt = mysqli_prepare($conexion, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $empleadoId);
        
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            echo json_encode($row);
        } else {
            echo json_encode(["error" => "Cliente no encontrado"]);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["error" => "Error al preparar la consulta"]);
    }
}