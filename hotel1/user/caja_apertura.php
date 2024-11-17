<?php
include "../user/includes/header.php";
?>


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

<?php include("../user/includes/footer.php"); ?>
