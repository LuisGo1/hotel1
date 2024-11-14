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
        flex-direction: column;
        align-items: center; 
        height: 100vh;
        margin: 0;
        background-color: #f0f0f0;
        font-family: Arial, sans-serif;
    }

    /* Contenedor de cierre de caja */
    .cierre-caja-container {
        background-color: #fff;
        width: 25%;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        margin-bottom: 20px;
        margin-left: 220px;
        margin-top: 70px;
    }

    /* Encabezado */
    .cierre-caja-container h2 {
        margin-top: 0;
        font-size: 24px;
        color: #333;
        border-bottom: 2px solid #4CAF50;
        padding-bottom: 10px;
        margin-bottom: 25px;
    }

    /* Campo de entrada */
    .form-group {
        margin-bottom: 20px;
        margin-right: 20px;
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
        margin-top: 15px;
    }

    .submit-btn:hover {
        background-color: #45a049;
    }

    /* Tabla de resumen */
    .tabla-resumen {
        width: 68%;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        margin-left: 220px;
    }

    .tabla-resumen table {
        width: 100%;
    }

    .tabla-resumen th, .tabla-resumen td {
        padding: 10px;
        text-align: center;
    }

    /* Estilos de estado */
    .estado-disponible {
        background-color: #4CAF50;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .estado-cerrado {
        background-color: #FF0000;
        color: white;
        padding: 5px 10px;
        border-radius: 5px;
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

    <div class="cierre-caja-container">
    <h2>Cierre de Caja</h2>
    <div class="form-group">
        <label for="fechaCierre">Fecha de Cierre</label>
        <input type="date" id="fechaCierre" name="fechaCierre">
    </div>
    <div class="form-group">
        <label for="montoCierre">Monto de Cierre</label>
        <input type="number" id="montoCierre" name="montoCierre" placeholder="0.00">
    </div>
    <button class="submit-btn" id="cerrarBtn" disabled>Cerrar</button>
</div>

<!-- Tabla de Resumen -->
<div class="tabla-resumen">
    <table id="resumenTable" class="display">
        <thead>
            <tr>
                <th>ID Caja</th>
                <th>Fecha Apertura</th>
                <th>Monto Apertura</th>
                <th>Fecha Cierre</th>
                <th>Monto Cierre</th>
                <th>Total Ingreso Día</th>
                <th>Total Egreso Día</th>
                <th>Saldo Final</th>
                <th>Estado</th>
                <th>Empleado ID</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>2024-11-12</td>
                <td>$. 1000</td>
                <td>2024-11-12</td>
                <td>$. 1500</td>
                <td>$/. 2000</td>
                <td>$/. 500</td>
                <td>$/. 1500</td>
                <td><span class="estado-cerrado">Cerrado</span></td>
                <td>101</td>
            </tr>
            <tr>
                <td>2</td>
                <td>2024-11-12</td>
                <td>$. 800</td>
                <td>2024-11-12</td>
                <td>$. 1200</td>
                <td>$. 1500</td>
                <td>$. 300</td>
                <td>$. 1200</td>
                <td><span class="estado-disponible">Disponible</span></td>
                <td>102</td>
            </tr>
        </tbody>
    </table>
</div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script>
    // Inicializa DataTables
    $(document).ready(function() {
        $('#resumenTable').DataTable();
    });
    </script>
    <script>
    // Habilita el botón solo si el monto es mayor a 0
    const montoCierreInput = document.getElementById("montoCierre");
    const cerrarBtn = document.getElementById("cerrarBtn");

    montoCierreInput.addEventListener("input", function() {
        cerrarBtn.disabled = montoCierreInput.value <= 0;
    });
    </script>
    <script>
    document.querySelectorAll('.dropdown-toggle').forEach(item => {
    item.addEventListener('click', (e) => {
        const menu = item.nextElementSibling;
        menu.style.display = (menu.style.display === 'block' ? 'none' : 'block');
        e.preventDefault();
        });
    });
    </script>

</body>
</html>
