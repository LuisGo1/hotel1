<?php
include "../../conecction/db.php";

// Verificamos que todos los datos requeridos estén presentes en $_POST
if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['telefono']) && isset($_POST['correo']) && isset($_POST['direccion']) && isset($_POST['comentarios'])) {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $direccion = trim($_POST['direccion']);
    $comentarios = $_POST['comentarios'];

    // Validamos que el teléfono sea un valor numérico
    if (!is_numeric($telefono)) {
        echo 'Número de teléfono inválido';
    } else {
        // Insertamos el cliente en la tabla, omitiendo el campo `fecha_registro`
        $consulta = "INSERT INTO `clientes` (nombre_cliente, apellido_client, telefono, email, direccion, comentarios) 
                     VALUES ('$nombre', '$apellido', '$telefono', '$correo', '$direccion', '$comentarios')";
        $resultado = mysqli_query($conexion, $consulta);

        if ($resultado) {
            echo 'Los datos se guardaron correctamente';
        } else {
            echo 'Ocurrió un error al guardar los datos: ' . mysqli_error($conexion);
        }
    }
} else {
    echo 'Datos incompletos';
}

// Cerramos la conexión
$conexion->close();
?>
