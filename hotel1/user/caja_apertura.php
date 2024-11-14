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
<style>
    /* Centrado del contenedor principal */
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f0f0f0;
        font-family: Arial, sans-serif;
    }
    /* Contenedor de apertura de caja */
    .apertura-caja-container {
            background-color: #fff;
            width: 400px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Encabezado */
        .apertura-caja-container h2 {
            margin-top: 0;
            font-size: 24px;
            color: #333;
            border-bottom: 2px solid #4CAF50;
            padding-bottom: 10px;
            margin-bottom: 25px; /* Más espacio debajo del título */
        }

        /* Campo de entrada */
        .form-group {
            margin-bottom: 20px; /* Más espacio entre los campos */
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #666;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        /* Botón */
        .submit-btn {
            width: 100%;
            padding: 15px;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 15px; /* Más espacio sobre el botón */
        }

        .submit-btn:hover {
            background-color: #45a049;
        }

        .submit-btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .submit-btn:hover:enabled {
            background-color: #45a049;
        }

        /* Estilo para el dropdown */
.dropdown {
    position: relative;
}

/* Estilo para el menú desplegable con animación */
.dropdown-menu {
    display: none;
    position: absolute;
    left: 100%;
    top: 0;
    background-color: #444;
    min-width: 160px;
    padding: 10px 0;
    border-radius: 4px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);

    /* Animación */
    opacity: 1;
    transform: translateY(-10px); /* Inicia un poco desplazado hacia arriba */
    transition: opacity 0.3s ease, transform 0.3s ease;
}

/* Mostrar el dropdown con animación cuando se hace hover */
.dropdown:hover .dropdown-menu {
    display: block;
    opacity: 1;
    transform: translateY(0); /* Desliza hacia su posición final */
}

        
</style>

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

    <div class="apertura-caja-container">
    <h2>Apertura de caja</h2>
    <div class="form-group">
        <label for="fecha">Fecha</label>
        <input type="date" id="fecha" name="fecha">
    </div>
    <div class="form-group">
        <label for="monto">Monto Inicial</label>
        <input type="number" id="monto" name="monto" placeholder="0.00">
    </div>
    <button id="submit-btn" class="submit-btn" disabled>Abrir</button>
</div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
    // Habilita el botón solo si el monto es mayor a 0
    const montoInput = document.getElementById("monto");
    const abrirBtn = document.getElementById("submit-btn");

    montoInput.addEventListener("input", function() {
        abrirBtn.disabled = montoInput.value <= 0;
    });
    </script>
</script>

</body>
</html>
