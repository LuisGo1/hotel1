<?php
include "../admin/includes/header.php";
?>
    <div class="main-content">
        <h1>Reservas</h1>

        <table id="tablaCheckInOut" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fecha Reserva</th>
                    <th>Habitación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Datos de ejemplo -->
                <tr>
                    <td>1</td>
                    <td>Juan Pérez</td>
                    <td>2024-11-10</td>
                    <td>101</td>
                    <td>
                        <button class="btnEditar" onclick="editarReserva(1)">Editar</button>
                        <button class="btnEliminar" onclick="eliminarReserva(1)">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Ana Gómez</td>
                    <td>2024-11-12</td>
                    <td>102</td>
                    <td>
                        <button class="btnEditar" onclick="editarReserva(2)">Editar</button>
                        <button class="btnEliminar" onclick="eliminarReserva(2)">Eliminar</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button id="btnNuevaReserva">Nueva Reserva</button>

        <!-- Modal para agregar nueva reserva -->
        <div id="modalReserva" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Agregar Reserva</h2>
                <form id="formNuevaReserva">
                    <label for="clienteReserva">Cliente:</label>
                    <input type="text" id="clienteReserva" required />
                    <label for="fechaReserva">Fecha Reserva:</label>
                    <input type="date" id="fechaReserva" required />
                    <label for="habitacionReserva">Habitación:</label>
                    <input type="number" id="habitacionReserva" required />
                    <button type="submit">Guardar</button>
                </form>
            </div>
        </div>
    </div>


</body>
<script src="../js/scripts.js"></script>
<?php include "../admin/includes/footer.php" ?>
<script>
    const modalaggEmpleado = document.getElementById("modalReserva");
    const btnAggEmpleado = document.getElementById("btnNuevaReserva");
    var span = document.getElementsByClassName("close")[0];

    btnAggEmpleado.onclick = function() {
        modalaggEmpleado.style.display = "block";
    };
    spanClose.onclick = function() {
        modalaggEmpleado.style.display = "none";
    };
    window.onclick = function(event) {
        if (event.target == modal) {
            modalaggHabitacion.style.display = "none"
        }
    }
</script>
</html>

