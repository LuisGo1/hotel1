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
                    <td>
                        <button class="btnEditar" data-id="<?php echo $fila['cliente_id']; ?>" onclick="editarCliente(this)">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btnEliminar" onclick="confirmDelete(<?php echo $fila['cliente_id']; ?>, '<?php echo $fila['nombre_cliente']; ?>')">
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
                <textarea id="comentariosCliente" name="comentariosCliente"></textarea>

                <button type="submit" id="Guardar">Guardar</button>
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
    // Manejo de modal
    const modalNuevoCliente = document.getElementById("modalCliente");
    const modalEditarCliente = document.getElementById("modalEditarCliente");
    const btnNuevoCliente = document.getElementById("btnNuevoCliente");
    const btnGuardar = document.getElementById("GuardarCambios");
    const btnClose = document.getElementById("btnclose");
    const btnCloseEditar = document.getElementById("btncloseEditar");

    btnNuevoCliente.onclick = function() {
        modalNuevoCliente.style.display = "block";
    };

    window.onclick = function(event) {
        if (event.target == modalNuevoCliente) {
            verificarYCerrarModalEdit();
        }
    };


    btnClose.onclick = function(event) {
        verificarYCerrarModalEdit();
    };

    function verificarYCerrarModalEdit() {
        // Obtener los valores de los campos del formulario
        var nombre = $('#nombreCliente').val().trim();
        var apellidos = $('#apellidoCliente').val().trim();
        var telefono = $('#telefonoCliente').val().trim();
        var email = $('#emailCliente').val().trim();
        var direccion = $('#direccionCliente').val().trim();
        var comentarios = $('#comentariosCliente').val().trim();

        // Si alguno de los campos tiene datos, mostrar advertencia antes de cerrar el modal
        if (nombre || apellidos || telefono || email || direccion || comentarios) {
            Swal.fire({
                title: 'Advertencia',
                text: 'Tienes campos llenos. ¿Estás seguro que quieres salir sin guardar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    limpiarCamposFormulario();
                    modalNuevoCliente.style.display = "none";
                    // Cerrar modal si el usuario confirma
                }
                // Si el usuario cancela, no hace nada y no se cierra el modal
            });
        } else {
            modalNuevoCliente.style.display = "none";

        }
    }

    function limpiarCamposFormulario() {
        $('#nombreCliente').val('');
        $('#apellidoCliente').val('');
        $('#telefonoCliente').val('');
        $('#emailCliente').val('');
        $('#direccionCliente').val('');
        $('#comentariosCliente').val('');
    }

    // Validación del formulario antes de enviarlo
    $(document).ready(function() {

        $('#Guardar').click(function(e) {
            e.preventDefault();

            // Capturamos los valores del formulario
            var nombre = $('#nombreCliente').val().trim();
            var apellidos = $('#apellidoCliente').val().trim();
            var telefono = $('#telefonoCliente').val().trim();
            var email = $('#emailCliente').val(); // Aquí eliminamos el .trim()
            var direccion = $('#direccionCliente').val().trim();
            var comentarios = $('#comentariosCliente').val().trim();

            // Verificamos si hay algún campo vacío
            if (nombre === '' || apellidos === '' || telefono === '' || email === '' || direccion === '') {
                Swal.fire({
                    title: 'Error',
                    text: 'Todos los campos son obligatorios',
                    icon: 'error'
                });
                return;
            }

            // Validación del teléfono
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

            // Verificamos los datos antes de enviarlos
            console.log("Datos a enviar:");
            console.log("Nombre: " + nombre);
            console.log("Apellidos: " + apellidos);
            console.log("telefono: " + telefono);
            console.log("Correo: " + email);
            console.log("direccion: " + direccion);
            console.log("comentarios: " + comentarios);
            // Realizamos la solicitud AJAX para enviar los datos al servidor
            $.ajax({
                type: 'POST',
                url: '../admin/con_clientes/agregarcliente.php',
                data: {
                    nombre: nombre,
                    apellidos: apellidos,
                    email: email, // Enviamos el valor seleccionado
                    telefono: telefono,
                    comentarios: comentarios,
                    direccion: direccion
                },
                success: function(data) {
                    console.log("Respuesta del servidor:");
                    console.log(data); // Aquí puedes ver la respuesta que llega del servidor
                    Swal.fire({
                        title: '¡Mensaje!',
                        text: data,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(function() {
                        window.location = "../admin/clientes.php";
                    });
                },
                error: function(xhr, status, error) {
                    console.log("Error en la solicitud AJAX:");
                    console.log(xhr.responseText); // Aquí puedes ver el error de la solicitud
                    Swal.fire({
                        title: 'Error',
                        text: xhr.responseText,
                        icon: 'error'
                    });
                },
                complete: function() {
                    $('#Guardar').prop('disabled', false); // Habilitar el botón después de la solicitud
                }
            });
        });
    });



    // Función para eliminar cliente
    function confirmDelete(cliente_id, nombre_cliente) {
        Swal.fire({
            title: "¿Estás seguro?",
            text: `Eliminarás al cliente ${nombre_cliente}.`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            confirmButtonColor: "#3085d6",
            cancelButtonText: "Cancelar",
            cancelButtonColor: "#d33",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `../admin/con_clientes/eleminarcliente.php?id=${cliente_id}`;
            }
        });
    }



    window.onclick = function(event) {
        if (event.target == modalEditarCliente) {
            verificarYCerrarModal();
        }
    };


    btnCloseEditar.onclick = function(event) {
        verificarYCerrarModal();
    };

    function verificarYCerrarModal() {



        var nombre = $('#editnombreCliente').val().trim();
        var apellidos = $('#editapellidoCliente').val().trim();
        var telefono = $('#editTelefonoCliente').val().trim();
        var email = $('#editcorreoCliente').val().trim();
        var direccion = $('#editdireccionCliente').val().trim();
        var comentarios = $('#editcomentariosCliente').val().trim();

        // Si alguno de los campos tiene datos, mostrar advertencia antes de cerrar el modal
        if (nombre || apellidos || telefono || email || direccion || comentarios) {
            Swal.fire({
                title: 'Advertencia',
                text: 'Tienes campos llenos. ¿Estás seguro que quieres salir sin guardar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    modalEditarCliente.style.display = "none";
                }
            });
        } else {
            modalEditarCliente.style.display = "none";

        }
    }


    // Función para abrir el modal cuando se hace clic en el botón de editar
    function editarCliente(button) {
        // Obtener el ID del empleado desde el atributo 'data-id' del botón
        const clienteId = button.getAttribute('data-id');
        console.log('ID del empleado:', clienteId);

        // Realizar una solicitud AJAX para obtener los datos del empleado
        $.ajax({
            type: 'GET',
            url: '../admin/con_clientes/obtenercliente.php', // Ruta al archivo PHP
            data: {
                id: clienteId
            }, // Enviar el ID del empleado
            success: function(data) {
                // Convertir la respuesta a formato JSON
                const cliente = JSON.parse(data);
                console.log('base', cliente);

                // Verificamos si la respuesta contiene un error
                if (cliente.error) {
                    Swal.fire({
                        title: 'Error',
                        text: cliente.error,
                        icon: 'error'
                    });
                    return;
                }

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
            e.preventDefault(); 


            var nombre = $('#editnombreCliente').val().trim();
            var apellidos = $('#editapellidoCliente').val().trim();
            var telefono = $('#editTelefonoCliente').val().trim();
            var email = $('#editcorreoCliente').val().trim();
            var direccion = $('#editdireccionCliente').val().trim();
            var comentarios = $('#editcomentariosCliente').val().trim();

            // Verificamos si algún campo obligatorio está vacío
            if (nombre === '' || apellidos === '' || telefono === '' || email === '' || direccion === '') {
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
                    id: clienteId, // ID del empleado que se va a actualizar
                    nombre: nombre,
                    apellidos: apellidos,
                    telefono: telefono,
                    correo: email,
                    direccion: direccion,
                    comentarios: comentarios
                    
                },
                success: function(data) {
                    // Verificamos la respuesta del servidor
                    const response = JSON.parse(data);
                    if (response.success) {
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Cliente actualizado correctamente',
                            timer: 1500,
                            showConfirmButton: false,
                            icon: 'success'
                        }).then(function() {
                            // Cerrar el modal y recargar la página o realizar otras acciones
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
                },
                error: function(xhr, status, error) {
                    console.log('Error al actualizar los datos del empleado:', xhr.responseText);
                    Swal.fire({
                        title: 'Error',
                        text: 'Hubo un problema al actualizar los datos del empleado.',
                        icon: 'error'
                    });
                }
            });
        });


    }
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
                // Redirect to the delete URL with the ID
                window.location.href = '../admin/con_clientes/eliminarcliente.php?id=' + cliente_id;
            }
        });
    }
</script>

</html>