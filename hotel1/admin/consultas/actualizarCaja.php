<?php
// Incluir la conexión a la base de datos
include "../../conecction/db.php";

// Verificamos si se recibió el ID del empleado
if (isset($_POST['id'])) {
    // Recogemos los datos del formulario
    $cajaId = $_POST['id'];
    $fecha_apertura = $_POST['fecha_apertura'];
    $monto_apertura = $_POST['monto_apertura'];
    $monto_cierre = $_POST['monto_cierre'];
    $fecha_cierre = $_POST['fecha_cierre'];
    $apertura = $_POST['apertura'];

    // Preparamos la consulta SQL para actualizar los datos en la base de datos
    $query = "UPDATE caja_diaria SET fecha_apertura = ?, monto_apertura = ?, monto_cierre = ?, fecha_cierre = ?, estado = ? WHERE caja_id = ?";

    // Preparamos la sentencia
    if ($stmt = mysqli_prepare($conexion, $query)) {
        // Vinculamos los parámetros a la consulta
        mysqli_stmt_bind_param($stmt, "sddssi", $fecha_apertura, $monto_apertura, $monto_cierre, $fecha_cierre, $apertura, $cajaId);

        // Ejecutamos la consulta
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["error" => "Error al actualizar los datos del empleado."]);
        }

        // Cerramos la sentencia
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["error" => "Error al preparar la consulta."]);
    }
} else {
    echo json_encode(["error" => "ID de empleado no recibido."]);
}

// Cerramos la conexión a la base de datos
mysqli_close($conexion);
?>
