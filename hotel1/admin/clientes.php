<?php
include "../admin/includes/header.php";
?>

<div class="main-content">
    <h1>Clientes</h1>

    <table id="tablaCheckInOut" class="display">
        <thead>
            <tr>
                <th>NOMBRE</th>
                <th>APELLIDO</th>
                <th>TELEFONO</th>
                <th>EMAIL</th>
                <th>DIRECCION</th>
                <th>COMENTARIOS</th>
                <th>FECHA DE REGISTRO</th>
                <th></th>
            </tr>
        </thead>

        <tbody>
            <?php
            include("../conecction/db.php");
            $result = mysqli_query($conexion, "SELECT cliente_id, nombre_cliente, apellido_cliente, telefono, email, direccion, comentarios, DATE(fecha_registro) as fecha FROM clientes;");
            while ($fila = mysqli_fetch_assoc($result)) :
            ?>
                <tr>
                    <td><?php echo $fila['nombre_cliente']; ?></td>
                    <td><?php echo $fila['apellido_cliente']; ?></td>
                    <td><?php echo $fila['telefono']; ?></td>
                    <td><?php echo $fila['email']; ?></td>
                    <td><?php echo $fila['direccion']; ?></td>
                    <td><?php echo $fila['comentarios']; ?></td>
                    <td><?php echo $fila['fecha']; ?></td>
                    <td>
                        <button class="btnEditar" data-id="<?php echo $fila['cliente_id']; ?>" onclick="editarCliente(this)">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btnEliminar" style="width: 60px; margin-left: 5px;" type="button" onclick="confirmDelete(<?php echo $fila['cliente_id']; ?>, '<?php echo $fila['nombre_cliente']; ?>')">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <button id="btnNuevoCliente">Nuevo Cliente</button>
    <a href="../admin/con_clientes/obtenercliente.php">asdas</a>

    <!-- Modal para agregar nuevo cliente -->
    <div id="modalCliente" class="modal">
        <div class="modal-content">
            <span class="close" id="btnclose">&times;</span>
            <h2>Agregar Cliente</h2>
            <form id="formNuevoCliente">
                <label for="nombreCliente">Nombre:</label>
                <input type="text" id="nombreCliente" name="nombreCliente" required />

                <label for="apellidoCliente">Apellidos:</label>
                <input type="text" id="apellidoCliente" name="apellidoCliente" required />

                <label for="telefonoCliente">Teléfono:</label>
                <input type="number" id="telefonoCliente" name="telefonoCliente" required />

                <label for="correoCliente">Correo:</label>
                <input type="email" id="correoCliente" name="correoCliente" required />

                <label for="direccionCliente">Dirección:</label>
                <input type="text" id="direccionCliente" name="direccionCliente" required />

                <label for="comentariosCliente">Comentarios:</label>
                <textarea id="comentariosCliente" name="comentariosCliente"></textarea>

                <label for="fechaRegistroCliente">Fecha de Registro:</label>
                <input type="date" id="fechaRegistroCliente" name="fechaRegistroCliente" required />

                <button type="submit" style="margin-top: 10px;" id="GuardarCliente">Guardar</button>
            </form>
        </div>
    </div>

    <!-- Modal para Editar cliente -->
    <div id="modalEditarCliente" class="modal">
        <div class="modal-content">
            <span class="close" id="btncloseEditar">&times;</span>
            <h2>Editar Cliente</h2>
            <form id="formEditarCliente">
                <label for="nombreCliente">Nombre:</label>
                <input type="text" id="EditnombreCliente" name="nombreCliente" required />

                <label for="apellidoCliente">Apellidos:</label>
                <input type="text" id="EditapellidoCliente" name="apellidoCliente" required />

                <label for="telefonoCliente">Teléfono:</label>
                <input type="number" id="EdittelefonoCliente" name="telefonoCliente" required />

                <label for="correoCliente">Correo:</label>
                <input type="email" id="EditcorreoCliente" name="correoCliente" required />

                <label for="direccionCliente">Dirección:</label>
                <input type="text" id="EditdireccionCliente" name="direccionCliente" required />

                <label for="comentariosCliente">Comentarios:</label>
                <textarea id="EditcomentariosCliente" name="comentariosCliente"></textarea>

                <label for="fechaRegistroCliente">Fecha de Registro:</label>
                <input type="date" id="EditfechaRegistroCliente" name="fechaRegistroCliente" required disabled />

                <button type="submit" style="margin-top: 10px;" id="GuardarCambiosCliente">Guardar Cambios</button>
            </form>
        </div>
    </div>

</div>

<script src="../js/scripts.js"></script>

<script>
    // Abre el modal para agregar nuevo cliente
    const modalAgregarCliente = document.getElementById("modalCliente");
    const modalEditarCliente = document.getElementById("modalEditarCliente");
    const btnNuevoCliente = document.getElementById("btnNuevoCliente");
    const btnCloseAgregar = document.getElementById("btnclose");
    const btnCloseEditar = document.getElementById("btncloseEditar");

    btnNuevoCliente.onclick = function() {
        modalAgregarCliente.style.display = "block";
    };

    btnCloseAgregar.onclick = function() {
        modalAgregarCliente.style.display = "none";
    };

    btnCloseEditar.onclick = function() {
        modalEditarCliente.style.display = "none";
    };

    // Función para confirmar eliminación
    function confirmDelete(cliente_id, nombre_cliente) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `Esta acción eliminará a ${nombre_cliente}.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../admin/consultas/eliminarcliente.php?id=' + cliente_id;
            }
        });
    }

    // Función para abrir modal de edición de cliente
    function editarCliente(button) {
        const clienteId = button.getAttribute('data-id');

        $.ajax({
            type: 'GET',
            url: '../admin/con_clientes/obtenercliente.php',
            data: { id: clienteId },
            success: function(data) {
                const cliente = JSON.parse(data);
                $('#EditnombreCliente').val(cliente.nombre_cliente);
                $('#EditapellidoCliente').val(cliente.apellido_cliente);
                $('#EdittelefonoCliente').val(cliente.telefono);
                $('#EditcorreoCliente').val(cliente.email);
                $('#EditdireccionCliente').val(cliente.direccion);
                $('#EditcomentariosCliente').val(cliente.comentarios);
                $('#EditfechaRegistroCliente').val(cliente.fecha_registro);
                modalEditarCliente.style.display = "block";
            },
            error: function(xhr, status, error) {
                Swal.fire('Error', 'Hubo un problema al cargar los datos del cliente.', 'error');
            }
        });
    }
</script>

<?php include "../admin/includes/footer.php" ?>
