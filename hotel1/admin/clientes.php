<?php
include "../admin/includes/header.php";
?>

<div class="main-content">
    <h1>Clientes</h1>

    <!-- Tabla de Clientes -->
    <table id="tablaClientes" class="display">
        <thead>
            <tr>
                <th>NOMBRE</th>
                <th>APELLIDO</th>
                <th>TELEFONO</th>
                <th>EMAIL</th>
                <th>DIRECCION</th>
                <th>COMENTARIOS</th>
                <th>FECHA DE REGISTRO</th>
                <th>ACCIONES</th>
            </tr>
        </thead>

        <tbody>
            <?php
            include("../conecction/db.php");
            $result = mysqli_query($conexion, "SELECT cliente_id, nombre_cliente, apellido_client, telefono, email, direccion, comentarios, DATE(fecha_registro) as fecha FROM clientes;");
            while ($fila = mysqli_fetch_assoc($result)) :
            ?>
                <tr>
                    <td><?php echo $fila['nombre_cliente']; ?></td>
                    <td><?php echo $fila['apellido_client']; ?></td>
                    <td><?php echo $fila['telefono']; ?></td>
                    <td><?php echo $fila['email']; ?></td>
                    <td><?php echo $fila['direccion']; ?></td>
                    <td><?php echo $fila['comentarios']; ?></td>
                    <td><?php echo $fila['fecha']; ?></td>
                    <td>
                        <button class="btnEditar" data-id="<?php echo $fila['cliente_id']; ?>" onclick="editarCliente(this)">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btnEliminar" data-id="<?php echo $fila['cliente_id']; ?>" onclick="confirmDelete(this)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <button id="btnNuevoCliente">Nuevo Cliente</button>

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

                <button type="submit" id="GuardarCliente">Guardar</button>
            </form>
        </div>
    </div>

    <!-- Modal para Editar cliente -->
    <div id="modalEditarCliente" class="modal">
        <div class="modal-content">
            <span class="close" id="btncloseEditar">&times;</span>
            <h2>Editar Cliente</h2>
            <form id="formEditarCliente">
                <label for="EditnombreCliente">Nombre:</label>
                <input type="text" id="EditnombreCliente" name="nombreCliente" required />

                <label for="EditapellidoCliente">Apellidos:</label>
                <input type="text" id="EditapellidoCliente" name="apellidoCliente" required />

                <label for="EdittelefonoCliente">Teléfono:</label>
                <input type="number" id="EdittelefonoCliente" name="telefonoCliente" required />

                <label for="EditcorreoCliente">Correo:</label>
                <input type="email" id="EditcorreoCliente" name="correoCliente" required />

                <label for="EditdireccionCliente">Dirección:</label>
                <input type="text" id="EditdireccionCliente" name="direccionCliente" required />

                <label for="EditcomentariosCliente">Comentarios:</label>
                <textarea id="EditcomentariosCliente" name="comentariosCliente"></textarea>

                <button type="submit" id="GuardarCambiosCliente">Guardar Cambios</button>
            </form>
        </div>
    </div>

</div>

<script src="../js/scripts.js"></script>

<script>
    // Abrir y cerrar modales
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
    function confirmDelete(button) {
        const clienteId = button.getAttribute('data-id');
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará al cliente.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: '../admin/con_clientes/eliminarcliente.php',
                    data: { id: clienteId },
                    success: function(response) {
                        Swal.fire('Cliente eliminado', 'El cliente fue eliminado correctamente', 'success')
                            .then(() => window.location.reload());
                    },
                    error: function(xhr) {
                        Swal.fire('Error', 'Hubo un problema al eliminar el cliente', 'error');
                    }
                });
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
                $('#EditnombreCliente').val(cliente.nombre_cliente).data('id', clienteId);
                $('#EditapellidoCliente').val(cliente.apellido_client);
                $('#EdittelefonoCliente').val(cliente.telefono);
                $('#EditcorreoCliente').val(cliente.email);
                $('#EditdireccionCliente').val(cliente.direccion);
                $('#EditcomentariosCliente').val(cliente.comentarios);
                modalEditarCliente.style.display = "block";
            },
            error: function() {
                Swal.fire('Error', 'Hubo un problema al cargar los datos del cliente.', 'error');
            }
        });
    }

    // Enviar datos para agregar cliente
    $('#GuardarCliente').click(function(e) {
        e.preventDefault();
        const clienteData = {
            nombre: $('#nombreCliente').val(),
            apellido: $('#apellidoCliente').val(),
            telefono: $('#telefonoCliente').val(),
            correo: $('#correoCliente').val(),
            direccion: $('#direccionCliente').val(),
            comentarios: $('#comentariosCliente').val()
        };

        $.ajax({
            type: 'POST',
            url: '../admin/con_clientes/agregarcliente.php',
            data: clienteData,
            success: function() {
                Swal.fire('Cliente agregado', 'El cliente fue agregado correctamente', 'success')
                    .then(() => window.location.reload());
            },
            error: function() {
                Swal.fire('Error', 'Hubo un problema al agregar el cliente', 'error');
            }
        });
    });

    // Enviar datos para editar cliente
    $('#GuardarCambiosCliente').click(function(e) {
        e.preventDefault();
        const clienteData = {
            id: $('#EditnombreCliente').data('id'),
            nombre: $('#EditnombreCliente').val(),
            apellido: $('#EditapellidoCliente').val(),
            telefono: $('#EdittelefonoCliente').val(),
            correo: $('#EditcorreoCliente').val(),
            direccion: $('#EditdireccionCliente').val(),
            comentarios: $('#EditcomentariosCliente').val()
        };

        $.ajax({
            type: 'POST',
            url: '../admin/con_clientes/actualizarCliente.php',
            data: clienteData,
            success: function() {
                Swal.fire('Cliente actualizado', 'El cliente fue actualizado correctamente', 'success')
                    .then(() => window.location.reload());
            },
            error: function() {
                Swal.fire('Error', 'Hubo un problema al actualizar el cliente', 'error');
            }
        });
    });
</script>

<?php include "../admin/includes/footer.php"; ?>
