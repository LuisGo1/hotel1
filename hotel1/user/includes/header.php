<?php
// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
// header("Pragma: no-cache"); // Para versiones antiguas de HTTP (HTTP/1.0)
// header("Expires: Thu, 01 Jan 1970 00:00:00 GMT"); 
// session_start();

// if (!isset($_SESSION['nivel_acceso'])) {
//     echo "<script language='JavaScript'>
//             alert('Error: Debes iniciar sesión primero.');
//             window.location.href = '../../hotel1/index.php';  // Redirige al login
//           </script>";
//     exit();
// }

// if ($_SESSION['nivel_acceso'] !== 'recepcionista') {
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
    <title>Habitaciones</title>

    <!-- Estilos de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.4/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a9f6dfd024.js" crossorigin="anonymous"></script>



    <!-- Tu archivo de CSS -->
    <link rel="stylesheet" href="../css/userstyle.css">
</head>
<header>
    <!-- <nav class="navbar">
        <div class="contenerdor-navbar">
            <i class="fa-solid fa-bars" id="menu-toggle"></i>
        </div>
    </nav>
</header> -->

<body>
    <!-- Menú Lateral -->
    <div class="sidebar">
    <img src="../admin/imagenes/logo.jpg" alt="Logo" class="logo-img">
    <h2 style="margin-top: 15px;"> Hotel Recepción Dashboard</h2>

    <ul class="nav-links">
        <li><a href="../user/"><i class="fa-solid fa-hotel"></i> <span>Inicio</span></a></li>
        <li><a href="../user/recepcion.php"><i class="fa-solid fa-id-badge"></i> <span>Recepción</span></a></li>
        <li class="dropdown1">
                <a href=""><i class="fa-solid fa-coins"></i> <span>Caja</span></a>
                <div class="dropdown1-content">
                    <a href="../user/caja_apertura.php">Apertura</a>
                    <a href="../user/caja_cierre.php">Cierre</a>
                </div>
            </li>        <!-- Línea divisoria -->
        <!-- Botón de Cerrar Sesión en la parte inferior -->
    </ul>
    <div class="bottom-section">
        <hr class="separate-line">
        <li class="logout"><a href=""><i class="fa-solid fa-right-to-bracket"></i><span>Cerrar Sesión</span></a></li>
    </div>
</div>