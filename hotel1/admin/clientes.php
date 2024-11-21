<?php
include "../admin/includes/header.php";
?>

<div class="main-content">
    <h1>Clientes</h1>

    <table id="tablaCheckInOut" class="display">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Dirección</th>
                <th>Comentarios</th>
                <th>Fecha de Registro</th>
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
                    <td style="display: flex;">
                        <button class="btnEditar" data-id="<?php echo $fila['cliente_id']; ?>" onclick="editarCliente(this)">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btnEliminar"style="width: 60px; margin-left: 5px;" onclick="confirmDelete(<?php echo $fila['cliente_id']; ?>, '<?php echo $fila['nombre_cliente']; ?>')">
                            <i class="fa fa-trash" aria-hidden="true"></i>
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

                <label for="apellidoCliente">Apellido:</label>
                <input type="text" id="apellidoCliente" name="apellidoCliente" required />

                <label for="telefonoCliente">Teléfono:</label>
                <input type="text" id="telefonoCliente" name="telefonoCliente" required />

                <label for="emailCliente">Correo:</label>
                <input type="email" id="emailCliente" name="emailCliente" required />

                <label for="direccionCliente">Dirección:</label>
                <input type="text" id="direccionCliente" name="direccionCliente" required />

                <label for="comentariosCliente">Comentarios:</label>
                <input id="comentariosCliente" name="comentariosCliente"></input>
                <button type="submit" id="Guardar" style="margin-top: 10px;">Guardar</button>
            </form>
        </div>
    </div>

    <!-- MODAL EDITAR CLIENTE -->
    <div id="modalEditarCliente" class="modal">
        <div class="modal-content">
            <span class="close" id="btncloseEditar">&times;</span>
            <h2>Editar Cliente</h2>
            <form id="formNuevoEmpleado">
                <label for="nombreCliente">Nombre:</label>
                <input type="text" id="editnombreCliente" name="nombreCliente" />

                <label for="apellidoCliente">Apellidos:</label>
                <input type="text" id="editapellidoCliente" name="apellidoCliente" />
                <label for="telefonocliente">Telefono:</label>
                <input type="text" id="editTelefonoCliente" name="telefonocliente" />

                <label for="correoCliente">Correo:</label>
                <input type="email" id="editcorreoCliente" name="correoCliente" />

                <label for="direccioncliente">Dirección:</label>
                <input type="text" id="editdireccionCliente" name="direccioncliente" />
                <label for="comentarioscliente">Comentarios:</label>
                <input type="text" id="editcomentariosCliente" name="comentarioscliente" />

                <button type="submit" style="margin-top: 10px;" id="GuardarCambios">Guardar Cambios</button>

            </form>
        </div>
    </div>



</div>

</body>

<script src="../js/scripts.js"></script>
<?php include "../admin/includes/footer.php"; ?>

<!-- SCRIPT PARA EL MANEJO DEL MODAL NUEVO CLIENTE -->
<script>
    // Manejo de modales
    const modalNuevoCliente = document.getElementById("modalCliente");
    const modalEditarCliente = document.getElementById("modalEditarCliente");
    const btnNuevoCliente = document.getElementById("btnNuevoCliente");
    const btnGuardar = document.getElementById("GuardarCambios");
    const btnClose = document.getElementById("btnclose");
    const btnCloseEditar = document.getElementById("btncloseEditar");

    // Abre el modal de nuevo cliente
    btnNuevoCliente.onclick = function() {
        modalNuevoCliente.style.display = "block";
    };

    // Cierra el modal si haces clic fuera del modal
    window.onclick = function(event) {
        if (event.target == modalNuevoCliente) {
            verificarYCerrarModal(modalNuevoCliente, '#nombreCliente', '#apellidoCliente', '#telefonoCliente', '#emailCliente', '#direccionCliente', '#comentariosCliente');
        }
        if (event.target == modalEditarCliente) {
            verificarYCerrarModal(modalEditarCliente, '#editnombreCliente', '#editapellidoCliente', '#editTelefonoCliente', '#editcorreoCliente', '#editdireccionCliente', '#editcomentariosCliente');
        }
    };

    // Función común para verificar y cerrar modales
    function verificarYCerrarModal(modal, ...fields) {
        const camposLlenos = fields.some(field => $(field).val().trim() !== '');

        if (camposLlenos) {
            Swal.fire({
                title: 'Advertencia',
                text: 'Tienes campos llenos. ¿Estás seguro que quieres salir sin guardar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    limpiarCamposFormulario(fields);
                    modal.style.display = "none";
                }
            });
        } else {
            modal.style.display = "none";
        }
    }

    // Función para limpiar los campos del formulario
    function limpiarCamposFormulario(fields) {
        fields.forEach(field => $(field).val(''));
    }

    // Cerrar el modal de nuevo cliente
    btnClose.onclick = function(event) {
        verificarYCerrarModal(modalNuevoCliente, '#nombreCliente', '#apellidoCliente', '#telefonoCliente', '#emailCliente', '#direccionCliente', '#comentariosCliente');
    };

    // Cerrar el modal de editar cliente
    btnCloseEditar.onclick = function(event) {
        verificarYCerrarModal(modalEditarCliente, '#editnombreCliente', '#editapellidoCliente', '#editTelefonoCliente', '#editcorreoCliente', '#editdireccionCliente', '#editcomentariosCliente');
    };

    // Validación del formulario de nuevo cliente
    $(document).ready(function() {
        $('#Guardar').click(function(e) {
            e.preventDefault();

            var nombre = $('#nombreCliente').val().trim();
            var apellidos = $('#apellidoCliente').val().trim();
            var telefono = $('#telefonoCliente').val().trim();
            var email = $('#emailCliente').val().trim();
            var direccion = $('#direccionCliente').val().trim();
            var comentarios = $('#comentariosCliente').val().trim();

            if (nombre === '' || apellidos === '' || telefono === '' || email === '' || direccion === '') {
                Swal.fire({
                    title: 'Error',
                    text: 'Todos los campos son obligatorios',
                    icon: 'error'
                });
                return;
            }

            var telefonoPattern = /^\d{8}$/;
            if (!telefonoPattern.test(telefono)) {
                Swal.fire({
                    title: 'Error',
                    text: 'Ingrese un teléfono válido',
                    icon: 'error'
                });
                return;
            }

            var correoPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!correoPattern.test(email)) {
                Swal.fire({
                    title: 'Error',
                    text: 'Ingrese un correo electrónico válido.',
                    icon: 'error'
                });
                return;
            }

            // Realizamos la solicitud AJAX para enviar los datos al servidor
            $.ajax({
                type: 'POST',
                url: '../admin/con_clientes/agregarcliente.php',
                data: {
                    nombre: nombre,
                    apellidos: apellidos,
                    email: email,
                    telefono: telefono,
                    comentarios: comentarios,
                    direccion: direccion
                },
                success: function(data) {
                    Swal.fire({
                        title: '¡Éxito!',
                        text: data,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function() {
                        window.location = "../admin/clientes.php";
                    });
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error',
                        text: xhr.responseText,
                        icon: 'error'
                    });
                }
            });
        });
    });


    function editarCliente(button) {
        // Obtener el ID del empleado desde el atributo 'data-id' del botón
        const cliente_id = button.getAttribute('data-id');
        console.log('ID del empleado:', cliente_id);

        // Realizar una solicitud AJAX para obtener los datos del empleado
        $.ajax({
            type: 'GET',
            url: '../admin/con_clientes/obtenercliente.php', // Ruta al archivo PHP
            data: {
                id: cliente_id
            }, // Enviar el ID del empleado
            success: function(data) {
                // Convertir la respuesta a formato JSON
                const cliente = JSON.parse(data);

                // Verificamos si la respuesta contiene un error
                if (cliente.error) {
                    Swal.fire({
                        title: 'Error',
                        text: cliente.error,
                        icon: 'error'
                    });
                    return;
                }

                // Rellenar los campos del formulario con los datos del empleado
                $('#editnombreCliente').val(cliente.nombre_cliente);
                $('#editapellidoCliente').val(cliente.apellido_cliente);
                $('#editTelefonoCliente').val(cliente.telefono);
                $('#editcorreoCliente').val(cliente.email);
                $('#editdireccionCliente').val(cliente.direccion);
                $('#editcomentariosCliente').val(cliente.comentarios);


                // Mostrar el modal con los datos del empleado
                $('#modalEditarCliente').show();
            },
            error: function(xhr, status, error) {
                console.log('Error al obtener los datos del empleado:', xhr.responseText);
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al cargar los datos del empleado.',
                    icon: 'error'
                });
            }
        });
        // Función para manejar el clic en el botón "Guardar Cambios" y realizar el update
        $('#GuardarCambios').click(function(e) {
            e.preventDefault(); // Evita el comportamiento por defecto del formulario

            // Recoger los datos del formulario
            const nombre = $('#editnombreCliente').val().trim();
            const apellidos = $('#editapellidoCliente').val().trim();
            const telefono = $('#editTelefonoCliente').val().trim();
            const email = $('#editcorreoCliente').val().trim();
            const direccion = $('#editdireccionCliente').val().trim();
            const comentarios = $('#editcomentariosCliente').val().trim();

            // Verificamos si algún campo obligatorio está vacío
            if (!nombre || !apellidos || !telefono || !email || !direccion) {
                Swal.fire({
                    title: 'Error',
                    text: 'Todos los campos son obligatorios',
                    icon: 'error'
                });
                return;
            }

            $.ajax({
                type: 'POST',
                url: '../admin/con_clientes/actualizarCliente.php',
                data: {
                    id: cliente_id,
                    nombre: nombre,
                    apellidos: apellidos,
                    telefono: telefono,
                    correo: email,
                    direccion: direccion,
                    comentarios: comentarios
                },
                success: function(data) {
                    try {
                        const response = JSON.parse(data);
                        if (response.success) {
                            Swal.fire({
                                title: 'Éxito',
                                text: 'Cliente actualizado correctamente',
                                timer: 1500,
                                showConfirmButton: false,
                                icon: 'success'
                            }).then(function() {
                                $('#modalEditarCliente').hide();
                                window.location.reload(); // Recargar la página
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.error,
                                icon: 'error'
                            });
                        }
                    } catch (error) {
                        console.log('Error al analizar la respuesta de actualización:', error);
                        Swal.fire({
                            title: 'Error',
                            text: 'Respuesta del servidor no válida.',
                            icon: 'error'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error al actualizar los datos del cliente:', xhr.responseText);
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un problema al actualizar los datos del cliente.',
                        icon: 'error'
                    });
                }
            });
        });
    }



    // Confirmación para eliminar cliente
    function confirmDelete(cliente_id, nombre_Cliente) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `Esta acción eliminará a ${nombre_Cliente}. ¿Estás seguro de eliminar a ${nombre_Cliente}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            confirmButtonColor: '#3085d6',
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#C4044A'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '../admin/con_clientes/eliminarcliente.php?id=' + cliente_id;
            }
        });
    };
    $('#cerrarsesion').click(function(e) {
        Swal.fire({
            title: 'Cerrar sesión',
            text: '¿Esta seguro de cerrar sesión?',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: 'Si, Cerrar Sesion',
            icon: "question"
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = '../validacion/cerrarsesion.php';
            }
        });
    });
</script>

</html>