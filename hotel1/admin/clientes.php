<?php
include "../admin/includes/header.php";

?>
    <div class="main-content">
        <h1>Clientes</h1>

        <table id="tablaCheckInOut" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Datos de ejemplo -->
                <tr>
                    <td>1</td>
                    <td>Juan Pérez</td>
                    <td>juan@email.com</td>
                    <td>1234567890</td>
                    <td>
                        <button class="btnEditar" onclick="editarCliente(1)">Editar</button>
                        <button class="btnEliminar" onclick="eliminarCliente(1)">Eliminar</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Ana Gómez</td>
                    <td>ana@email.com</td>
                    <td>0987654321</td>
                    <td>
                        <button class="btnEditar" onclick="editarCliente(2)">Editar</button>
                        <button class="btnEliminar" onclick="eliminarCliente(2)">Eliminar</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <button id="btnNuevoCliente">Agregar Cliente</button>

        <!-- Modal para agregar cliente -->
        <div id="modalCliente" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Agregar Cliente</h2>
                <form id="formNuevoCliente">
                    <label for="nombreCliente">Nombre:</label>
                    <input type="text" id="nombreCliente" required />
                    <label for="emailCliente">Email:</label>
                    <input type="email" id="emailCliente" required />
                    <label for="telefonoCliente">Teléfono:</label>
                    <input type="text" id="telefonoCliente" required />
                    <button type="submit">Guardar</button>
                </form>
            </div>
        </div>
    </div>
    </body>
<?php include "../admin/includes/footer.php";?>
<script>
     const modalaggEmpleado = document.getElementById("modalCliente");
    const btnAggEmpleado = document.getElementById("btnNuevoCliente");
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