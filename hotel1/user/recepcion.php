<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitaciones</title>

    <!-- Estilos de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

    <!-- Tu archivo de CSS -->
    <link rel="stylesheet" href="../../hotel1/css/userstyle.css">
</head>
<body>

    <div class="sidebar">
        <h2>Hotel Admin Dashboard</h2>
        <ul>
            <li><a href="../user/">Dashboard</a></li>
            <li><a href="../user/recepcion.html">Recepción</a></li>
            <li><a href="../admin/clientes.html">Clientes</a></li>
            <li><a href="../admin/reservas.html">Reservas</a></li>
            <li><a href="../admin/habitaciones.html">Habitaciones</a></li>
            <li><a href="../admin/empleados.html">Empleados</a></li>
        </ul>
    </div>

</div>

    <section class="levels">
        <div class="level-card">Nivel 1</div>
        <div class="level-card">Nivel 2</div>
        <div class="level-card">Nivel 3</div>
        <div class="level-card">Nivel 4</div>
    </section>

    <div class="room-container">
        <!-- Cuadros de habitaciones -->
        <div class="room-card cleaning">
            <div class="room-number">Habitación 101</div>
            <div class="room-type">Simple</div>
            <div class="room-status">Limpieza</div>
        </div>

        <div class="room-card occupied">
            <div class="room-number">Habitación 102</div>
            <div class="room-type">Matrimonial</div>
            <div class="room-status">Ocupado</div>
        </div>

        <div class="room-card available">
            <div class="room-number">Habitación 103</div>
            <div class="room-type">Familiar</div>
            <div class="room-status">Disponible</div>
        </div>

        <div class="room-card available">
            <div class="room-number">Habitación 104</div>
            <div class="room-type">Doble</div>
            <div class="room-status">Disponible</div>
        </div>

        <div class="room-card occupied">
            <div class="room-number">Habitación 105</div>
            <div class="room-type">Simple</div>
            <div class="room-status">Ocupado</div>
        </div>

        <div class="room-card maintenance">
            <div class="room-number">Habitación 106</div>
            <div class="room-type">Simple</div>
            <div class="room-status">Mantenimiento</div>
        </div>
    </div>

    <section class="status">
        <div class="level-card">Disponible
            <span>2</span>
        </div>
        <div class="level-card">Ocupado
            <span>1</span>
        </div>
        <div class="level-card">Limpieza
            <span>1</span>
        </div>
        <div class="level-card">Mantenimiento
            <span>5</span>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

</body>
</html>
