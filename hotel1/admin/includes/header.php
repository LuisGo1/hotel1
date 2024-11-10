<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrativo del Hotel</title>
    <link rel="stylesheet" href="../css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.semanticui.css">



    <script src="https://kit.fontawesome.com/a9f6dfd024.js" crossorigin="anonymous"></script>
</head>
<header>
    <nav class="navbar">
    <div class="contenerdor-navbar">
    <i class="fa-solid fa-bars"></i>
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
        <li><a href="../../hotel1/admin/check.php"><i class="fa-regular fa-pen-to-square"></i> <span>Check-In <br> Check-Out</span></a></li>
        <li><a href="../../hotel1/admin/clientes.php"><i class="fa-solid fa-user-plus"></i> <span>Clientes</span></a></li>
        <li><a href="../../hotel1/admin/reservas.php"><i class="fa-solid fa-calendar-check"></i> <span>Reservas</span></a></li>
        <li><a href="../../hotel1/admin/habitaciones.php"><i class="fa-solid fa-bed"></i> <span>Habitaciones</span></a></li>
        <li><a href="../../hotel1/admin/empleados.php"><i class="fa-solid fa-user-tie"></i> <span>Empleados</span></a></li>

        <!-- Línea divisoria -->
        <hr style="border: 0.5px solid #ffffff; opacity: 0.1; margin: 60px 20px 0px 20px;">

        <li><a href=""><i class="fa-solid fa-right-to-bracket"></i> <span>Cerrar Sesión</span></a></li>
    </ul>
</div>

