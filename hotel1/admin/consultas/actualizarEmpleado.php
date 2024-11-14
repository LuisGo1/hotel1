<?php
// Incluir la conexión a la base de datos
include "../../conecction/db.php";

// Verificamos si se recibió el ID del empleado
if (isset($_POST['id'])) {
    // Recogemos los datos del formulario
    $empleadoId = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];
    $estado=$_POST['estado'];
    $fechaIngreso = $_POST['fechaIngreso'];

    // Si la contraseña no está vacía, la actualizamos
    if (!empty($password)) {
        $password = password_hash($password, PASSWORD_BCRYPT); // Encriptamos la contraseña
        $query = "UPDATE empleados SET nombre_empleado = ?, apellido_empleado = ?, email = ?, rol = ?, telefono = ?,estado = ?, password = ?  WHERE empleado_id = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "sssssssi", $nombre, $apellidos, $correo, $rol, $telefono,$estado, $password,  $empleadoId);
    } else {
        // Si no se cambia la contraseña, no la actualizamos
        $query = "UPDATE empleados SET nombre_empleado = ?, apellido_empleado = ?, email = ?, rol = ?, telefono = ?, estado = ?  WHERE empleado_id = ?";
        $stmt = mysqli_prepare($conexion, $query);
        mysqli_stmt_bind_param($stmt, "ssssssi", $nombre, $apellidos, $correo, $rol, $telefono,$estado,  $empleadoId);
    }

    // Ejecutamos la consulta
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Error al actualizar los datos del empleado."]);
    }

    // Cerramos la sentencia
    mysqli_stmt_close($stmt);
} else {
    echo json_encode(["error" => "ID de empleado no recibido."]);
}

// Cerramos la conexión a la base de datos
mysqli_close($conexion);
?>
