<?php
// Incluir la conexión a la base de datos
include "../../conecction/db.php";

// Verificamos si se recibió el ID del empleado
if (isset($_POST['id'])) {
    // Recogemos los datos del formulario
    $clienteId = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $direccion = $_POST['direccion'];
    $comentarios = $_POST['comentarios'];

    // Preparamos la consulta SQL para actualizar los datos en la base de datos
    $query = "UPDATE clientes SET nombre_cliente = ?, apellido_cliente = ?, telefono = ?, email = ?, direccion = ?, comentarios = ? WHERE cliente_id = ?";

    // Preparamos la sentencia
    if ($stmt = mysqli_prepare($conexion, $query)) {
        // Vinculamos los parámetros a la consulta
        mysqli_stmt_bind_param($stmt, "ssssssi", $nombre, $apellidos, $telefono, $correo, $direccion, $comentarios, $clienteId);

        // Ejecutamos la consulta
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["error" => "Error al actualizar los datos del cliente."]);
        }

        // Cerramos la sentencia
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["error" => "Error al preparar la consulta."]);
    }
} else {
    echo json_encode(["error" => "ID del cliente no recibido."]);
}

// Cerramos la conexión a la base de datos
mysqli_close($conexion);
?>
