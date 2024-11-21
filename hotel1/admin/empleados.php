<?php
include "../admin/includes/header.php";
?>

<div class="main-content">
    <h1>Empleados</h1>

    <table id="tablaCheckInOut" class="display">
        <thead>
            <tr>

                <th>NOMBRE</th>
                <th>APELLIDO</th>
                <th>EMAIL</th>
                <th>TELEFONO</th>
                <th>ROL</th>
                <th>INGRESO</th>
                <th>ESTADO</th>
                <th></th>

            </tr>
        </thead>

        <tbody>
            <?php
            include("../conecction/db.php");
            $result = mysqli_query($conexion, " SELECT *, DATE(fecha_ingreso) as fecha, estado FROM empleados;
");
            while ($fila = mysqli_fetch_assoc($result)) :
            ?>
                <tr>
                    <td><?php echo $fila['nombre_empleado']; ?></td>
                    <td><?php echo $fila['apellido_empleado']; ?></td>
                    <td><?php echo $fila['email']; ?></td>
                    <td><?php echo $fila['telefono']; ?></td>
                    <td><?php echo $fila['rol']; ?></td>
                    <td><?php echo $fila['fecha']; ?></td>
                    <td class="estado-padre">
                        <span class="estado-texto <?php echo ($fila['estado'] == 'activo') ? 'activo' : 'inactivo'; ?>">
                            <?php echo $fila['estado']; ?>
                        </span>
                    </td>

                    <td>
                        <button class="btnEditar" data-id="<?php echo $fila['empleado_id']; ?>" onclick="editarEmpleado(this)">
                            <i class="fa fa-edit"></i>
                            <button class="btnEliminar" style="width: 60px; margin-left: 5px;" type="button" onclick="confirmDelete(<?php echo $fila['empleado_id']; ?>, '<?php echo $fila['nombre_empleado']; ?>')">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                    </td>

                </tr>
            <?php endwhile; ?>
        </tbody>

    </table>

    <button id="btnNuevoEmpleado">Nuevo Empleado</button>

    <!-- Modal para agregar nuevo empleado -->
    <div id="modalEmpleado" class="modal">
        <div class="modal-content">
            <span class="close" id="btnclose">&times;</span>
            <h2>Agregar Empleado</h2>
            <form id="formNuevoEmpleado">
                <label for="nombreEmpleado">Nombre:</label>
                <input type="text" id="nombreEmpleado" name="nombreEmpleado" required />

                <label for="apellidoEmpleado">Apellidos:</label>
                <input type="text" id="apellidoEmpleado" name="apellidoEmpleado" required />

                <label for="correoEmpleado">Correo:</label>
                <input type="email" id="correoEmpleado" name="correoEmpleado" required />

                <label for="rolEmpleado">Rol:</label>
                <select id="rolEmpleado" name="rolEmpleado" required>
                    <option value="">Selecciona un rol</option>
                    <option value="administrador">administrador</option>
                    <option value="recepcionista">recepcionista</option>
                    <!-- Puedes agregar más opciones según sea necesario -->
                </select>

                <label for="telefonoEmpleado">Teléfono:</label>
                <input type="number" id="telefonoEmpleado" name="telefonoEmpleado" required />

                <label for="passwordEmpleado">Contraseña:</label>
                <input type="password" id="passwordEmpleado" name="passwordEmpleado"
                    title="La contraseña debe tener al menos 8 caracteres. 
Una letra mayúscula.
Una minúscula y un número."
                    required />

                <label for="fechaIngresoEmpleado">Fecha de Ingreso:</label>
                <input type="date" id="fechaIngresoEmpleado" name="fechaIngresoEmpleado" required />

                <button type="submit" style="margin-top: 10px;" id="Guardar">Guardar</button>

            </form>
        </div>
    </div>


    <!-- Modal para Editar  empleado -->
    <div id="modalEditarEmpleado" class="modal">
        <div class="modal-content">
            <span class="close" id="btncloseEditar">&times;</span>
            <h2>Editar Empleado</h2>
            <form id="formNuevoEmpleado">
                <label for="nombreEmpleado">Nombre:</label>
                <input type="text" id="EditnombreEmpleado" name="nombreEmpleado" required />

                <label for="apellidoEmpleado">Apellidos:</label>
                <input type="text" id="EditapellidoEmpleado" name="apellidoEmpleado" required />

                <label for="correoEmpleado">Correo:</label>
                <input type="email" id="EditcorreoEmpleado" name="correoEmpleado" required />

                <label for="rolEmpleado">Rol:</label>
                <select id="EditrolEmpleado" name="rolEmpleado" required>
                    <option value="">Selecciona un rol</option>
                    <option value="administrador">administrador</option>
                    <option value="recepcionista">recepcionista</option>
                    <!-- Puedes agregar más opciones según sea necesario -->
                </select>

                <label for="telefonoEmpleado">Teléfono:</label>
                <input type="number" id="EdittelefonoEmpleado" name="telefonoEmpleado" required />

                <label for="passwordEmpleado">Contraseña:</label>
                <input type="password" id="EditpasswordEmpleado" name="passwordEmpleado"
                    title="La contraseña debe tener al menos 8 caracteres. 
Una letra mayúscula.
Una minúscula y un número."
                    required />
                <label for="rolEmpleado">Estado:</label>
                <select id="EditEstadoEmpleado" name="rolEmpleado" required>
                    <option value="">Selecciona un estado</option>
                    <option value="activo">ACTIVO</option>
                    <option value="inactivo">INACTIVO</option>
                    <!-- Puedes agregar más opciones según sea necesario -->
                </select>
                <label for="fechaIngresoEmpleado">Fecha de Ingreso:</label>
                <input type="date" id="EditfechaIngresoEmpleado" name="fechaIngresoEmpleado" required disabled />

                <button type="submit" style="margin-top: 10px;" id="GuardarCambios">Guardar Cambios</button>

            </form>
        </div>
    </div>


</div>
</body>
<script src="../js/scripts.js"></script>


<?php include "../admin/includes/footer.php" ?>


<script src="../js/scripts.js"></script>

<!-- SCRIPT PARA EL MANEJO DEL MODAL NUEVO EMPLEADO -->
<script>
    // Manejo de modal
    const modalaggEmpleado = document.getElementById("modalEmpleado");
    const modaleditEmpleado = document.getElementById("modalEditarEmpleado");
    const btnAggEmpleado = document.getElementById("btnNuevoEmpleado");
    const spanCloseAgg = document.getElementById("btnclose");
    const spanCloseEdit = document.getElementById("btncloseEditar");

    btnAggEmpleado.onclick = function() {
        modalaggEmpleado.style.display = "block";
    };
    window.onclick = function(event) {
        if (event.target == modalaggEmpleado) {
            verificarYCerrarModal();
        } else if (event.target == modaleditEmpleado) {
            verificarYCerrarModalEdit();
        }
    };
    spanCloseAgg.onclick = function() {
        verificarYCerrarModal();
    };


    spanCloseEdit.onclick = function() {
        verificarYCerrarModalEdit();
    };


    // Validación del formulario antes de enviarlo
    $(document).ready(function() {

        $('#Guardar').click(function(e) {
            e.preventDefault();

            // Capturamos los valores del formulario
            var nombre = $('#nombreEmpleado').val().trim();
            var apellidos = $('#apellidoEmpleado').val().trim();
            var correo = $('#correoEmpleado').val().trim();
            var rol = $('#rolEmpleado').val(); // Aquí eliminamos el .trim()
            var telefono = $('#telefonoEmpleado').val().trim();
            var password = $('#passwordEmpleado').val().trim();
            var fecha = $('#fechaIngresoEmpleado').val().trim();

            // Verificamos si hay algún campo vacío
            if (nombre === '' || apellidos === '' || correo === '' || rol === '' || telefono === '' ||
                password === '' || fecha === '') {
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

            // Validación de la contraseña
            var passwordError = /^.{8,}$/;
            if (!passwordError.test(password)) {
                Swal.fire({
                    title: 'Error',
                    text: 'La contraseña debe tener al menos 8 caracteres.',
                    icon: 'error'
                });
                return;
            }
            var correoPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!correoPattern.test(correo)) {
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
            console.log("Correo: " + correo);
            console.log("Rol: " + rol);
            console.log("Teléfono: " + telefono);
            console.log("Fecha de Ingreso: " + fecha);

            // Realizamos la solicitud AJAX para enviar los datos al servidor
            $.ajax({
                type: 'POST',
                url: '../admin/consultas/AgregarEmpleado.php',
                data: {
                    nombre: nombre,
                    apellidos: apellidos,
                    correo: correo,
                    rol: rol, // Enviamos el valor seleccionado
                    telefono: telefono,
                    password: password,
                    fecha: fecha
                },
                success: function(data) {
                    console.log("Respuesta del servidor:");
                    console.log(data); // Aquí puedes ver la respuesta que llega del servidor
                    Swal.fire({
                        title: '¡Mensaje!',
                        text: data,
                        icon: 'success',
                        showConfirmButton: true
                    }).then(function() {
                        window.location = "../admin/empleados.php";
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



    // Función para verificar si hay datos y evitar el cierre del modal si hay datos ingresados
    function verificarYCerrarModal() {
        // Obtener los valores de los campos del formulario
        var nombre = $('#nombreEmpleado').val().trim();
        var apellidos = $('#apellidoEmpleado').val().trim();
        var correo = $('#correoEmpleado').val().trim();
        var rol = $('#rolEmpleado').val().trim();
        var telefono = $('#telefonoEmpleado').val().trim();
        var password = $('#passwordEmpleado').val().trim();
        var fecha = $('#fechaIngresoEmpleado').val().trim();

        // Si alguno de los campos tiene datos, mostrar advertencia antes de cerrar el modal
        if (nombre || apellidos || correo || telefono || password) {
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
                    modalaggEmpleado.style.display = "none"; // Cerrar modal si el usuario confirma
                }
                // Si el usuario cancela, no hace nada y no se cierra el modal
            });
        } else {
            modalaggEmpleado.style.display = "none";
        }
    }



    function verificarYCerrarModalEdit() {
        // Obtener los valores de los campos del formulario
        var nombre = $('#EditnombreEmpleado').val().trim();
        var apellidos = $('#EditapellidoEmpleado').val().trim();
        var correo = $('#EditcorreoEmpleado').val().trim();
        var rol = $('#EditrolEmpleado').val().trim();
        var telefono = $('#EdittelefonoEmpleado').val().trim();
        var password = $('#EditpasswordEmpleado').val().trim();
        var fecha = $('#EditfechaIngresoEmpleado').val().trim();

        // Si alguno de los campos tiene datos, mostrar advertencia antes de cerrar el modal
        if (nombre || apellidos || correo || telefono || password) {
            Swal.fire({
                title: 'Advertencia',
                text: 'Tienes campos llenos. ¿Estás seguro que quieres salir sin guardar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    modaleditEmpleado.style.display = "none";
                    // Cerrar modal si el usuario confirma
                }
                // Si el usuario cancela, no hace nada y no se cierra el modal
            });
        } else {
            modaleditEmpleado.style.display = "none";

        }
    }


    function limpiarCamposFormulario() {
        $('#nombreEmpleado').val('');
        $('#apellidoEmpleado').val('');
        $('#correoEmpleado').val('');
        $('#rolEmpleado').val('');
        $('#telefonoEmpleado').val('');
        $('#passwordEmpleado').val('');
        $('#fechaIngresoEmpleado').val('');
    }


    // Script Fecha actual
    document.addEventListener("DOMContentLoaded", function() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0'); // Día con dos dígitos
        var mm = String(today.getMonth() + 1).padStart(2, '0'); // Mes con dos dígitos
        var yyyy = today.getFullYear(); // Año en 4 dígitos

        today = yyyy + '-' + mm + '-' + dd; // Formato: YYYY-MM-DD

        document.getElementById("fechaIngresoEmpleado").value = today;
    });


    // Función para abrir el modal cuando se hace clic en el botón de editar
    // Función para abrir el modal cuando se hace clic en el botón de editar
    function editarEmpleado(button) {
        // Obtener el ID del empleado desde el atributo 'data-id' del botón
        const empleadoId = button.getAttribute('data-id');
        console.log('ID del empleado:', empleadoId); // Imprime el ID en la consola
        isEditMode = true;

        // Realizar una solicitud AJAX para obtener los datos del empleado
        $.ajax({
            type: 'GET',
            url: '../admin/consultas/obtenerempleado.php', // Ruta al archivo PHP
            data: {
                id: empleadoId
            }, // Enviar el ID del empleado
            success: function(data) {
                // Convertir la respuesta a formato JSON
                const empleado = JSON.parse(data);

                // Verificamos si la respuesta contiene un error
                if (empleado.error) {
                    Swal.fire({
                        title: 'Error',
                        text: empleado.error,
                        icon: 'error'
                    });
                    return;
                }

                // Rellenar los campos del formulario con los datos del empleado
                $('#EditnombreEmpleado').val(empleado.nombre_empleado);
                $('#EditapellidoEmpleado').val(empleado.apellido_empleado);
                $('#EditcorreoEmpleado').val(empleado.email);
                $('#EditrolEmpleado').val(empleado.rol);
                $('#EdittelefonoEmpleado').val(empleado.telefono);
                $('#EditpasswordEmpleado').val(''); // No mostrar la contraseña por seguridad
                $('#EditEstadoEmpleado').val(empleado.estado);
                const fechaIngreso = empleado.fecha_ingreso;
                const fechaFormateada = new Date(fechaIngreso);
                const fechaString = fechaFormateada.toISOString().split('T')[0]; // Obtiene la parte YYYY-MM-DD
                document.getElementById('EditfechaIngresoEmpleado').value = fechaString;


                // Mostrar el modal con los datos del empleado
                $('#modalEditarEmpleado').show();
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
            var nombre = $('#EditnombreEmpleado').val().trim();
            var apellidos = $('#EditapellidoEmpleado').val().trim();
            var correo = $('#EditcorreoEmpleado').val().trim();
            var rol = $('#EditrolEmpleado').val().trim();
            var telefono = $('#EdittelefonoEmpleado').val().trim();
            var password = $('#EditpasswordEmpleado').val().trim();
            var estado = $('#EditEstadoEmpleado').val().trim();
            var fechaIngreso = $('#EditfechaIngresoEmpleado').val().trim(); // La fecha no debe ser editada

            // Verificamos si algún campo obligatorio está vacío
            if (nombre === '' || apellidos === '' || correo === '' || rol === '' || telefono === '') {
                Swal.fire({
                    title: 'Error',
                    text: 'Todos los campos son obligatorios',
                    icon: 'error'
                });
                return;
            }

            // Realizar la solicitud AJAX para actualizar los datos en el servidor
            $.ajax({
                type: 'POST',
                url: '../admin/consultas/actualizarEmpleado.php', // Ruta al archivo PHP que manejará el update
                data: {
                    id: empleadoId, // ID del empleado que se va a actualizar
                    nombre: nombre,
                    apellidos: apellidos,
                    correo: correo,
                    rol: rol,
                    telefono: telefono,
                    password: password, // La contraseña solo se actualizará si se ha introducido un nuevo valor
                    estado: estado, // La contraseña solo se actualizará si se ha introducido un nuevo valor
                    fechaIngreso: fechaIngreso // La fecha no se edita, solo se envía tal como está
                },
                success: function(data) {
                    // Verificamos la respuesta del servidor
                    const response = JSON.parse(data);
                    if (response.success) {
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Empleado actualizado correctamente',
                            timer: 1500,
                            showConfirmButton: false,
                            icon: 'success'
                        }).then(function() {
                            // Cerrar el modal y recargar la página o realizar otras acciones
                            $('#modalEditarEmpleado').hide();
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

    function confirmDelete(empleado_id, nombre_empleado) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `Esta acción eliminará a ${nombre_empleado}. ¿Estás seguro de eliminar a ${nombre_empleado}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            confirmButtonColor: '#3085d6',
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#C4044A'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the delete URL with the ID
                window.location.href = '../admin/consultas/eliminarempleado.php?id=' + empleado_id;
            }
        });
    }
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