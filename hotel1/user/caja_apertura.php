<?php include("../user/includes/header.php");?>

<body class="body_caja_apertura">
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


    <script>
    // Habilita el botón solo si el monto es mayor a 0
    const montoInput = document.getElementById("monto");
    const abrirBtn = document.getElementById("submit-btn");

    montoInput.addEventListener("input", function() {
        abrirBtn.disabled = montoInput.value <= 0;
    });
    </script>

</body>
<?php include("../user/includes/footer.php"); ?>
</html>
