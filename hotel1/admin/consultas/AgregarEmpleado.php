<?php
include "../../conecction/db.php";

if (isset($_POST['nombre']) && isset($_POST['apellidos']) && isset($_POST['telefono']) && isset($_POST['correo']) && isset($_POST['rol']) && isset($_POST['fecha'])&& isset($_POST['password']) ) {
    $nombre = trim($_POST['nombre']);
    $apellidos = trim($_POST['apellidos']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $rol = $_POST['rol'];
    $fecha = $_POST['fecha'];
    $password = $_POST['password'];
// Use 'id_estado' directly from the POST data

    // Ensure that $id_estado is a numeric value to prevent SQL injection
    if ( !is_numeric($telefono) ) {
        echo 'Invalid Numero de telefono value';
    } else {
        $consulta = "INSERT INTO `empleados`(nombre_empleado, apellido_empleado, rol, telefono, email, fecha_ingreso, password) 
        VALUES ('$nombre','$apellidos','$rol','$telefono','$correo','$fecha','$password')";
        $resultado = mysqli_query($conexion, $consulta);

        if ($resultado) {
            echo 'Los Datos Se Guardaron Correctamente';
        } else {
            echo 'Ocurrió un error al guardar los datos: ' . mysqli_error($conexion);
        }
    }
} else {
    echo 'No data';
}

$conexion->close();
?>