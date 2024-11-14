<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache"); // Para versiones antiguas de HTTP (HTTP/1.0)
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT"); 
session_start();

if (!isset($_SESSION['nivel_acceso'])) {
    echo "<script language='JavaScript'>
            alert('Error: Debes iniciar sesión primero.');
            window.location.href = '../../hotel1/index.php';  // Redirige al login
          </script>";
    exit();
}

if ($_SESSION['nivel_acceso'] !== 'recepcionista') {
    echo "<script language='JavaScript'>
            alert('Error: No tienes permisos para acceder a esta página.');
            window.history.back();  // Regresa a la página anterior (dashboard o donde estaba)
          </script>";
    exit();  
}

if (!isset($_SESSION['nombre_empleado'])) {
    echo "<script language='JavaScript'>
            alert('Error: Usuario no autenticado. Debes iniciar sesión primero.');
            window.location.href = '../../hotel1/index.php';  // Redirige al login
          </script>";
    exit();
}

$nombreUsuario = $_SESSION['nombre_empleado'];
$nivelAcceso = $_SESSION['nivel_acceso'];

if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 3000) {  // 3000 segundos = 50 minutos
    session_unset();  
    session_destroy();  
    echo "<script language='JavaScript'>
            alert('Error: La sesión ha expirado.');
            window.location.href = '../../hotel1/index.php';  // Redirige al login
          </script>";
    exit();  
} else {
    $_SESSION['last_activity'] = time();  
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitaciones</title>

    <!-- Estilos de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

    <!-- Tu archivo de CSS -->
    <link rel="stylesheet" href="../css/userstyle.css">
</head>

<body>

    <div class="sidebar">
        <h2>Hotel Admin Dashboard</h2>
        <ul>
            <li><a href="../user/">Dashboard</a></li>
            <li><a href="../user/recepcion.php">Recepción</a></li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle">Caja</a>
                <ul class="dropdown-menu">
                    <li><a href="../user/caja_apertura.php">Apertura de caja</a></li>
                    <li><a href="../user/caja_cierre.php">Cierre de caja</a></li>
                </ul>
            </li>
        </ul>
    </div>

</div>