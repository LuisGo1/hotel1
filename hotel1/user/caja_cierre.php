<?php
include "../user/includes/header.php";
?>

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
