<?php
// Incluir la conexión a la base de datos
include "../../conecction/db.php";

// Verificamos si el parámetro 'id' ha sido enviado
if (isset($_GET['id'])) {
    $empleadoId = $_GET['id'];

    // Preparamos la consulta para obtener los datos del empleado
    $query = "SELECT * FROM empleados WHERE empleado_id = ?";
    
    // Preparamos la sentencia
    if ($stmt = mysqli_prepare($conexion, $query)) {
        // Vinculamos el parámetro
        mysqli_stmt_bind_param($stmt, "i", $empleadoId);
        
        // Ejecutamos la consulta
        mysqli_stmt_execute($stmt);
        
        // Obtenemos el resultado
        $result = mysqli_stmt_get_result($stmt);

        // Verificamos si encontramos el empleado
        if ($row = mysqli_fetch_assoc($result)) {
            // Si encontramos el empleado, devolvemos los datos en formato JSON
            echo json_encode($row);
        } else {
            // Si no encontramos el empleado, enviamos un mensaje de error
            echo json_encode(["error" => "Empleado no encontrado"]);
        }

        // Cerramos la sentencia
        mysqli_stmt_close($stmt);
    } else {
        // Si ocurre un error al preparar la consulta
        echo json_encode(["error" => "Error al preparar la consulta"]);
    }
} else {
    // Si no se recibe el ID en la solicitud
    echo json_encode(["error" => "ID de empleado no recibido"]);
}

// Cerramos la conexión a la base de datos
mysqli_close($conexion);
?>
