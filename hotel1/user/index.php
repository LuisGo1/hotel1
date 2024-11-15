<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrativo del Hotel</title>
    <link rel="stylesheet" href="../../hotel1/css/userstyle.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>
<body>
    <!-- Menú Lateral -->
    <div class="sidebar">
        <h2>Hotel Admin Dashboard</h2>
        <ul>
            <li><a href="../../hotel1/user/index.php">Dashboard</a></li>
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
    <!-- Contenido Principal -->
    <div class="main-content">
        <h1>Bienvenido al Panel de usuario.</h1>
        <p>Seleccione una opción del menú lateral para gestionar las habitaciones del hotel.</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        // Controla el desplegable del menú "Caja"
        document.addEventListener("DOMContentLoaded", function() {
            const dropdownToggle = document.querySelector(".dropdown-toggle");
            const dropdown = document.querySelector(".dropdown");

            dropdownToggle.addEventListener("click", function(e) {
                e.preventDefault();
                dropdown.classList.toggle("active");
            });
        });
    </script>
</body>
</html>
