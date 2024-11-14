<?php
include "../../conecction/db.php";

if (isset($_POST['nombre'], $_POST['apellidos'], $_POST['email'], $_POST['telefono'], $_POST['comentarios'], $_POST['direccion'])) {
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $apellidos = htmlspecialchars(trim($_POST['apellidos']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $telefono = trim($_POST['telefono']);
    $comentarios = htmlspecialchars($_POST['comentarios']);
    $direccion = htmlspecialchars($_POST['direccion']);

    if (!is_numeric($telefono)) {
        echo 'Invalid Numero de telefono value';
    } else {
        $consulta = "INSERT INTO clientes (nombre_cliente, apellido_cliente, telefono, email, direccion, comentarios) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($consulta);
        
        if ($stmt) {
            $stmt->bind_param("ssssss", $nombre, $apellidos, $telefono, $email, $direccion, $comentarios);
            
            if ($stmt->execute()) {
                echo 'Los Datos Se Guardaron Correctamente';
            } else {
                echo 'Ocurrió un error al guardar los datos: ' . $stmt->error;
            }
            
            $stmt->close();
        } else {
            echo 'Error al preparar la consulta: ' . $conexion->error;
        }
    }
} else {
    echo 'No data';
}

mysqli_close($conexion);
?>
