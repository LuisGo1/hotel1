<?php
include("../conecction/db.php");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache"); 
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT"); 
session_start(); 

if (isset($_POST['correo']) && isset($_POST['password'])) {
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $query = "SELECT * FROM empleados WHERE email = '$correo' AND password = '$password'";

    $result = $conexion->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if ($row['rol'] == 'recepcionista') {
            $_SESSION['correo'] = $correo;
            $_SESSION['nivel_acceso'] = 'recepcionista';
            $_SESSION['nombre_empleado'] = $row['nombre_empleado'];

            echo "../hotel1/user/recepcion.php"; 
            exit();
        } elseif ($row['rol'] == 'administrador') {
            $_SESSION['correo'] = $correo;
            $_SESSION['nivel_acceso'] = 'administrador';
            $_SESSION['nombre_empleado'] = $row['nombre_empleado'];

            echo "../hotel1/admin/index.php"; 
            exit();
        }
    }

    echo "Error: Usuario o Contraseña Son Incorrectas";
}

$conexion->close();
?>
