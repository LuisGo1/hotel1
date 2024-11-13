<?php
include "../admin/includes/header.php";
?>

<div class="main-content">
    <h1>Habitaciones</h1>

    <table id="tablaCheckInOut" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tipo de Habitación</th>
                <th>Precio</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Datos de ejemplo -->
            <tr>
                <td>101</td>
                <td>Individual</td>
                <td>$50</td>
                <td>Disponible</td>
                <td>
                    <button class="btnEditar" onclick="editarHabitacion(101)">Editar</button>
                    <button class="btnEliminar" onclick="eliminarHabitacion(101)">Eliminar</button>
                </td>
            </tr>
            <tr>
                <td>102</td>
                <td>Doble</td>
                <td>$80</td>
                <td>Ocupada</td>
                <td>
                    <button class="btnEditar" onclick="editarHabitacion(102)">Editar</button>
                    <button class="btnEliminar" onclick="eliminarHabitacion(102)">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

    <button id="btnNuevaHabitacion">Nueva Habitación</button>

    <!-- Modal para agregar nueva habitación -->
    <div id="modalHabitacion" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Agregar Habitación</h2>
            <form id="formNuevaHabitacion">
                <label for="tipoHabitacion">Tipo de Habitación:</label>
                <input type="text" id="tipoHabitacion" required />
                <label for="precioHabitacion">Precio:</label>
                <input type="number" id="precioHabitacion" required />
                <label for="estadoHabitacion">Estado:</label>
                <select id="estadoHabitacion" required>
                    <option value="disponible">Disponible</option>
                    <option value="ocupada">Ocupada</option>
                    <option value="reservada">Reservada</option>
                    <option value="mantenimiento">Mantenimiento</option>
                </select>
                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>
</div>
</body>
<script src="../js/scripts.js"></script>
<script>
    const modalaggHabitacion = document.getElementById("modalHabitacion");
    const btnAggHabitacion = document.getElementById("btnNuevaHabitacion");
    var span = document.getElementsByClassName("close")[0];

    btnAggHabitacion.onclick = function() {
        modalaggHabitacion.style.display = "block";
    };
    spanClose.onclick = function() {
        modalaggHabitacion.style.display = "none";
    };
    window.onclick = function(event) {
        if (event.target == modal) {
            modalaggHabitacion.style.display = "none"
        }
    }
</script>
<?php include "../admin/includes/footer.php" ?>

</html>