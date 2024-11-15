<?php
// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
// header("Pragma: no-cache"); 
// header("Expires: Thu, 01 Jan 1970 00:00:00 GMT"); 
// session_start();

// if (!isset($_SESSION['nivel_acceso'])) {
//     echo "<script language='JavaScript'>
//             alert('Error: Debes iniciar sesión primero.');
//             window.location.href = '../../hotel1/index.php';  // Redirige al login
//           </script>";
//     exit();
// }

// if ($_SESSION['nivel_acceso'] !== 'administrador') {
//     echo "<script language='JavaScript'>
//             alert('Error: No tienes permisos para acceder a esta página.');
//             window.history.back();  // Regresa a la página anterior (dashboard o donde estaba)
//           </script>";
//     exit();  
// }

// if (!isset($_SESSION['nombre_empleado'])) {
//     echo "<script language='JavaScript'>
//             alert('Error: Usuario no autenticado. Debes iniciar sesión primero.');
//             window.location.href = '../../hotel1/index.php';  // Redirige al login
//           </script>";
//     exit();
// }

// $nombreUsuario = $_SESSION['nombre_empleado'];
// $nivelAcceso = $_SESSION['nivel_acceso'];

// if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 3000) {  // 3000 segundos = 50 minutos
//     session_unset();  
//     session_destroy(); 
//     echo "<script language='JavaScript'>
//             alert('Error: La sesión ha expirado.');
//             window.location.href = '../../hotel1/index.php';  // Redirige al login
//           </script>";
//     exit();  
// } else {
//     $_SESSION['last_activity'] = time(); 
// }
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrativo del Hotel</title>
    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.semanticui.css">

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.4/dist/sweetalert2.min.css" rel="stylesheet">




    <script src="https://kit.fontawesome.com/a9f6dfd024.js" crossorigin="anonymous"></script>
</head>
<header>
    <nav class="navbar">
        <div class="contenerdor-navbar">
            <i class="fa-solid fa-bars" id="menu-toggle"></i>
        </div>
    </nav>
</header>
<body>
    <!-- Menú Lateral -->
    <div class="sidebar">
    <img src="../admin/imagenes/logo.jpg" alt="Logo" class="logo-img">
    <h2 style="margin-top: 15px;"> Hotel Admin Dashboard</h2>

    <ul>
        <li><a href="../../hotel1/admin/index.php"><i class="fa-solid fa-hotel"></i> <span>Dashboard</span></a></li>
        <li><a href="../../hotel1/admin/check.php"><i class="fa-regular fa-pen-to-square"></i> <span>Check-In<br>Check-Out</span></a></li>
        <li><a href="../../hotel1/admin/caja.php"><i class="fa-solid fa-coins"></i> <span>Caja Diaria</span></a></li>
        <li><a href="../../hotel1/admin/clientes.php"><i class="fa-solid fa-user-plus"></i> <span>Huespedes</span></a></li>
        <li><a href="../../hotel1/admin/reservas.php"><i class="fa-solid fa-calendar-check"></i> <span>Reservas</span></a></li>
        <li><a href="../../hotel1/admin/habitaciones.php"><i class="fa-solid fa-bed"></i><span>Habitaciones</span></a></li>
        <li><a href="../../hotel1/admin/empleados.php"><i class="fa-solid fa-user-tie"></i> <span>Empleados</span></a></li>

        

        <!-- Línea divisoria -->
        <hr class="separate-line" >

        <li><a href=""><i class="fa-solid fa-right-to-bracket"></i><span>Cerrar Sesión</span></a></li>
    </ul>
</div>

