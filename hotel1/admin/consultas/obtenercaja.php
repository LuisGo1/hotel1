<?php
// Incluir la conexión a la base de datos
include "../../conecction/db.php";

// Verificamos si el parámetro 'id' ha sido enviado
if (isset($_GET['id'])) {
    $cajaId = $_GET['id'];

    // Preparamos la consulta para obtener los datos de la caja
    $query = "SELECT *, cj.estado as estado_caja 
              FROM caja_diaria as cj 
              JOIN empleados as emp ON cj.empleado_id = emp.empleado_id 
              WHERE cj.caja_id = ?";

    // Preparamos la sentencia
    if ($stmt = mysqli_prepare($conexion, $query)) {
        // Vinculamos el parámetro
        mysqli_stmt_bind_param($stmt, "i", $cajaId);

        // Ejecutamos la consulta
        mysqli_stmt_execute($stmt);

        // Obtenemos el resultado
        $result = mysqli_stmt_get_result($stmt);

        // Verificamos si encontramos la caja
        if ($row = mysqli_fetch_assoc($result)) {
            // Devolvemos los datos en formato JSON
            echo json_encode($row);
        } else {
            // Si no se encuentra la caja, enviamos un mensaje de error
            echo json_encode(["error" => "Caja no encontrada"]);
        }

        // Cerramos la sentencia
        mysqli_stmt_close($stmt);
    } else {
        // Error al preparar la consulta
        echo json_encode(["error" => "Error al preparar la consulta"]);
    }
} else {
    // Si no se recibe el ID en la solicitud
    echo json_encode(["error" => "ID de caja no recibido"]);
}

// Cerramos la conexión a la base de datos
mysqli_close($conexion);
?>
