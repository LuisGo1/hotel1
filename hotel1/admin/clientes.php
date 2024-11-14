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
                    <td><?php echo $fila['fecha_registro']; ?></td>
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
    <a href="../admin/con_clientes/obtenercliente.php">asdas</a>

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

<script src="../js/scripts.js"></script>
<!-- SCRIPT PARA EL MANEJO DEL MODAL NUEVO CLIENTE -->
<script>
    // Manejo de modal
    const modalNuevoCliente = document.getElementById("modalCliente");
    const btnNuevoCliente = document.getElementById("btnNuevoCliente");
    const btnClose = document.getElementById("btnclose");

    btnNuevoCliente.onclick = function () {
        modalNuevoCliente.style.display = "block";
    };

    window.onclick = function (event) {
        if (event.target == modalNuevoCliente) {
            modalNuevoCliente.style.display = "none";
        }
    };

    // Validación del formulario antes de enviarlo
    $(document).ready(function () {
        $("#Guardar").click(function (e) {
            e.preventDefault();

            // Capturamos los valores del formulario
            var nombre = $("#nombreCliente").val().trim();
            var apellido = $("#apellidoCliente").val().trim();
            var telefono = $("#telefonoCliente").val().trim();
            var email = $("#emailCliente").val().trim();
            var direccion = $("#direccionCliente").val().trim();
            var comentarios = $("#comentariosCliente").val().trim();

            // Verificamos si hay algún campo vacío
            if (
                nombre === "" ||
                apellido === "" ||
                telefono === "" ||
                email === "" ||
                direccion === ""
            ) {
                Swal.fire({
                    title: "Error",
                    text: "Todos los campos son obligatorios, excepto comentarios.",
                    icon: "error",
                });
                return;
            }

            // Validación del teléfono
            var telefonoPattern = /^\d{8,15}$/;
            if (!telefonoPattern.test(telefono)) {
                Swal.fire({
                    title: "Error",
                    text: "Ingrese un teléfono válido (entre 8 y 15 dígitos).",
                    icon: "error",
                });
                return;
            }

            // Validación del correo
            var correoPattern =
                /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!correoPattern.test(email)) {
                Swal.fire({
                    title: "Error",
                    text: "Ingrese un correo electrónico válido.",
                    icon: "error",
                });
                return;
            }

            // Realizamos la solicitud AJAX para enviar los datos al servidor
            $.ajax({
                type: "POST",
                url: "../admin/con_clientes/obtenercliente.php",
                data: {
                    accion: "agregar",
                    nombre: nombre,
                    apellido: apellido,
                    telefono: telefono,
                    email: email,
                    direccion: direccion,
                    comentarios: comentarios,
                },
                success: function (data) {
                    console.log("Respuesta del servidor:", data);
                    const response = JSON.parse(data);
                    if (response.success) {
                        Swal.fire({
                            title: "¡Éxito!",
                            text: "Cliente agregado correctamente.",
                            icon: "success",
                            showConfirmButton: true,
                        }).then(function () {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: response.error || "Ocurrió un problema.",
                            icon: "error",
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.log("Error en la solicitud AJAX:", xhr.responseText);
                    Swal.fire({
                        title: "Error",
                        text: xhr.responseText || "No se pudo completar la solicitud.",
                        icon: "error",
                    });
                },
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

    // Función para abrir el modal cuando se hace clic en el botón de editar
    function editarCliente(button) {
        const clienteId = button.getAttribute("data-id");

        // Realizar una solicitud AJAX para obtener los datos del cliente
        $.ajax({
            type: 'GET',
            url: '../admin/consultas/obtenercliente.php',
            data: { id: clienteId },
            success: function(data) {
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
                $("#nombreCliente").val(cliente.nombre_cliente);
                $("#apellidoCliente").val(cliente.apellido_client);
                $("#telefonoCliente").val(cliente.telefono);
                $("#emailCliente").val(cliente.email);
                $("#direccionCliente").val(cliente.direccion);
                $("#comentariosCliente").val(cliente.comentarios);

                // Mostrar el modal con los datos del cliente
                modalNuevoCliente.style.display = "block";
            },
            error: function (xhr, status, error) {
                console.log("Error al obtener los datos del cliente:", xhr.responseText);
                Swal.fire({
                    title: "Error",
                    text: "Hubo un problema al cargar los datos del cliente.",
                    icon: "error",
                });
            },
        });
    }
</script>



<?php include "../admin/includes/footer.php"; ?>
