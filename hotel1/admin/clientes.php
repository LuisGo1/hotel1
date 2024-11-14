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
</div>
<!-- Modal para Editar Cliente -->
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
            <input type="text" id="EdittelefonoCliente" name="telefonoCliente" required />

            <label for="emailCliente">Correo:</label>
            <input type="email" id="EditemailCliente" name="emailCliente" required />

            <label for="direccionCliente">Dirección:</label>
            <input type="text" id="EditdireccionCliente" name="direccionCliente" required />

            <label for="comentariosCliente">Comentarios:</label>
            <textarea id="EditcomentariosCliente" name="comentariosCliente"></textarea>

            <label for="fechaRegistroCliente">Fecha de Registro:</label>
            <input type="text" id="EditfechaRegistroCliente" name="fechaRegistroCliente" disabled />

            <button type="submit" style="margin-top: 10px;" id="GuardarCambios">Guardar Cambios</button>
        </form>
    </div>
</div>

</body>

<script src="../js/scripts.js"></script>
<?php include "../admin/includes/footer.php"; ?>

<!-- SCRIPT PARA EL MANEJO DEL MODAL NUEVO CLIENTE -->
<script>
    // Manejo de modal
    const modalNuevoCliente = document.getElementById("modalCliente");
    const modaleditEmpleado = document.getElementById("modalEditarCliente");
    const btnNuevoCliente = document.getElementById("btnNuevoCliente");
    const btnClose = document.getElementById("btnclose");

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
        var email= $('#emailCliente').val().trim();
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
            if (nombre === '' || apellidos === '' || telefono === '' || email === '' || direccion === '' ) {
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
                        timer:1500,
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
  // Función para abrir el modal cuando se hace clic en el botón de editar
  function editarCliente(button) {
        // Obtener el ID del cliente desde el atributo 'data-id' del botón
        const clienteId = button.getAttribute("data-id");

        // Realizar una solicitud AJAX para obtener los datos del cliente
        $.ajax({
            type: "GET",
            url: "../admin/con_cliente/obtenercliente.php", // Ruta al archivo PHP
            data: {
                accion: "obtener",
                id: clienteId,
            }, // Enviar el ID del cliente
            success: function (data) {
                // Convertir la respuesta a formato JSON
                const cliente = JSON.parse(data);

                // Verificamos si la respuesta contiene un error
                if (cliente.error) {
                    Swal.fire({
                        title: "Error",
                        text: cliente.error,
                        icon: "error",
                    });
                    return;
                }

                // Rellenar los campos del formulario con los datos del cliente
                $("#EditnombreCliente").val(cliente.nombre_cliente);
                $("#EditapellidoCliente").val(cliente.apellido_client);
                $("#EdittelefonoCliente").val(cliente.telefono);
                $("#EditemailCliente").val(cliente.email);
                $("#EditdireccionCliente").val(cliente.direccion);
                $("#EditcomentariosCliente").val(cliente.comentarios);

                // Mostrar el modal con los datos del cliente
                modalEditarCliente.style.display = "block";

                // Actualizar cliente al guardar cambios
                $("#GuardarCambios").off("click").on("click", function (e) {
                    e.preventDefault();

                    // Recoger los datos actualizados del formulario
                    var nombre = $("#EditnombreCliente").val().trim();
                    var apellido = $("#EditapellidoCliente").val().trim();
                    var telefono = $("#EdittelefonoCliente").val().trim();
                    var email = $("#EditemailCliente").val().trim();
                    var direccion = $("#EditdireccionCliente").val().trim();
                    var comentarios = $("#EditcomentariosCliente").val().trim();

                    // Realizar la solicitud AJAX para actualizar los datos
                    $.ajax({
                        type: "POST",
                        url: "../admin/con_cliente/actualizarCliente.php", // Ruta al archivo PHP
                        data: {
                            accion: "editar",
                            id: clienteId,
                            nombre: nombre,
                            apellido: apellido,
                            telefono: telefono,
                            email: email,
                            direccion: direccion,
                            comentarios: comentarios,
                        },
                        success: function (data) {
                            const response = JSON.parse(data);
                            if (response.success) {
                                Swal.fire({
                                    title: "¡Éxito!",
                                    text: "Cliente actualizado correctamente.",
                                    icon: "success",
                                    timer: 1500,
                                    showConfirmButton: false,
                                }).then(function () {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: response.error || "Hubo un problema al actualizar.",
                                    icon: "error",
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(
                                "Error al actualizar el cliente:",
                                xhr.responseText
                            );
                            Swal.fire({
                                title: "Error",
                                text: "No se pudo completar la solicitud.",
                                icon: "error",
                            });
                        },
                    });
                });
            },
            error: function (xhr, status, error) {
                console.log("Error al obtener los datos del cliente:", xhr.responseText);
                Swal.fire({
                    title: "Error",
                    text: "Hubo un problema al cargar los datos.",
                    icon: "error",
                });
            },
        });
    }

    function confirmDelete(cliente_id, nombre_cliente) {
        Swal.fire({
            title: "¿Estás seguro?",
            text: `Esta acción eliminará al cliente ${nombre_cliente}.`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            confirmButtonColor: "#3085d6",
            cancelButtonText: "Cancelar",
            cancelButtonColor: "#d33",
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirigir a la URL para eliminar
                window.location.href = '../admin/con_cliente/eliminarcliente.php?id=' + cliente_id;
            }
        });
    }
</script>      
</html>