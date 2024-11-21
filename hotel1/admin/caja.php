<?php
include "../admin/includes/header.php";
?>
<!-- Contenido principal -->
<div class="main-content">
    <h1>Caja Diaria</h1>

    <table id="tablaCheckInOut" class="display">
        <thead>
            <tr>

                <th>EMPLEADO</th>
                <th>APERTURA</th>
                <th>MONTO APERTURA</th>
                <th>CIERRE</th>
                <th>MONTO CIERRE</th>
                <th>TOTAL</th>
                <th>APERTURA</th>
                <th></th>

            </tr>
        </thead>

        <tbody>
            <?php
            include("../conecction/db.php");
            $result = mysqli_query($conexion, "SELECT *,cj.estado as estado_caja FROM caja_diaria as cj JOIN empleados as emp ON cj.empleado_id=emp.empleado_id;");
            while ($fila = mysqli_fetch_assoc($result)) :
            ?>
                <tr>
                    <td><?php echo $fila['nombre_empleado'] . ' ' . $fila['apellido_empleado']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($fila['fecha_apertura'])); ?></td>
                    <td style="text-align: center;">$<?php echo $fila['monto_apertura']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($fila['fecha_cierre'])); ?></td>
                    <td style="text-align: center;">$<?php echo $fila['monto_cierre']; ?></td>
                    <td style="text-align: center;">$<?php echo $fila['total_ingreso_dia']; ?></td>
                    <td class="estado-padre">
                        <span class="estado-texto <?php echo ($fila['estado_caja'] == 'abierta') ? 'abierta' : 'cerrada'; ?>">
                            <?php echo $fila['estado_caja']; ?>
                        </span>
                    </td>

                    <td>
                        <button class="btnEditar" data-id="<?php echo $fila['caja_id']; ?>" onclick="editarEmpleado(this)">
                            <i class="fa fa-edit"></i>
                            <button class="btnEliminar" style="width: 60px; margin-left: 5px;" type="button" onclick="confirmDelete(<?php echo $fila['caja_id']; ?>, '<?php echo $fila['fecha_apertura']; ?>')">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                    </td>

                </tr>
            <?php endwhile; ?>
        </tbody>

    </table>




    <!-- Modal para Editar  empleado -->
    <div id="modalEditarCaja" class="modal">
        <div class="modal-content">
            <span class="close" id="btncloseEditar">&times;</span>
            <h2>Editar Empleado</h2>
            <form id="formNuevoEmpleado">
                <label for="nombreCompletoEmpleado">Nombre de Empleado:</label>
                <input type="text" id="EditnombreCompletoEmpleado" name="nombreCompletoEmpleado" required disabled />

                <label for="fechaapertura">Fecha de Apertura:</label>
                <input type="date" id="fechaapertura" name="fechaapertura" required />
                <label for="montoapertura">Monto de Apertura:</label>
                <input type="number" id="montoapertura" name="montoapertura" step="0.01" placeholder="$0.00" required />
                <label for="fechacierre">Fecha de Cierre:</label>
                <input type="date" id="fechacierre" name="fechaapertura" required />
                <label for="montocierre">Monto de Cierre:</label>
                <input type="number" id="montocierre" name="montocierre" step="0.01" placeholder="$0.00" required />


                <label for="apertura">Apertura:</label>
                <select id="apertura" name="apertura" required>
                    <option value="abierta">ABIERTA</option>
                    <option value="cerrada">CERRADA</option>
                    <!-- Puedes agregar más opciones según sea necesario -->
                </select>


                <button type="submit" style="margin-top: 10px;" id="GuardarCambios">Guardar Cambios</button>

            </form>
        </div>
    </div>


</div>
</body>
<?php include "../admin/includes/footer.php" ?>
<script>
    const modaleditCaja = document.getElementById("modalEditarCaja");
    var span1 = document.getElementById("btncloseEditar");



    span1.onclick = function(event) {
        verificarYCerrarModalEdit();
    };
    window.onclick = function(event) {
        if (event.target == modaleditCaja) {
            verificarYCerrarModalEdit();
        }
    };

    function verificarYCerrarModalEdit() {
        // Obtener los valores de los campos del formulario
        var fechaapertura = $('#fechaapertura').val().trim();
        var montoapertura = $('#montoapertura').val().trim();
        var fechacierre = $('#fechacierre').val().trim();
        var montocierre = $('#montocierre').val().trim();
        var Editapertuda = $('#apertura').val().trim();

        // Si alguno de los campos tiene datos, mostrar advertencia antes de cerrar el modal
        if (fechaapertura || montoapertura || fechacierre || montocierre || Editapertuda) {
            Swal.fire({
                title: 'Advertencia',
                text: 'Tienes campos llenos. ¿Estás seguro que quieres salir sin guardar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    modaleditCaja.style.display = "none";
                    // Cerrar modal si el usuario confirma
                }
                // Si el usuario cancela, no hace nada y no se cierra el modal
            });
        } else {
            modaleditCaja.style.display = "none";

        }
    }

    function editarEmpleado(button) {
        // Obtener el ID del empleado desde el atributo 'data-id' del botón
        const cajaId = button.getAttribute('data-id');

        // Realizar una solicitud AJAX para obtener los datos del empleado
        $.ajax({
            type: 'GET',
            url: '../admin/consultas/obtenercaja.php', // Ruta al archivo PHP
            data: {
                id: cajaId
            }, // Enviar el ID del empleado
            success: function(data) {
                // Convertir la respuesta a formato JSON
                const caja = JSON.parse(data);
                // Verificamos si la respuesta contiene un error
                if (caja.error) {
                    Swal.fire({
                        title: 'Error',
                        text: caja.error,
                        icon: 'error'
                    });
                    return;
                }

                // Convertir `fecha_cierre` a formato "YYYY-MM-DD" para mostrarlo en el input tipo `date`
                if (caja.fecha_cierre) {
                    const fechacierreDate = new Date(caja.fecha_cierre);
                    caja.fecha_cierre = fechacierreDate.toISOString().split('T')[0];
                }

                // Concatenar nombre y apellido
                const nombreCompleto = `${caja.nombre_empleado} ${caja.apellido_empleado}`;

                // Rellenar los campos del formulario con los datos del empleado
                $('#fechacierre').val(caja.fecha_cierre);
                $('#EditnombreCompletoEmpleado').val(nombreCompleto);
                $('#fechaapertura').val(caja.fecha_apertura);
                $('#montoapertura').val(caja.monto_apertura);
                $('#montocierre').val(caja.monto_cierre);
                $('#apertura').val(caja.estado_caja);

                // Almacenar `cajaId` en el botón de guardar cambios
                $('#GuardarCambios').data('id', cajaId);

                // Mostrar el modal con los datos del empleado
                $('#modalEditarCaja').show();
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al cargar los datos del empleado.',
                    icon: 'error'
                });
            }
        });
    }

    // Función para manejar el clic en el botón "Guardar Cambios" y realizar el update
    $('#GuardarCambios').click(function(e) {
        e.preventDefault(); // Evita el comportamiento por defecto del formulario

        // Obtener `cajaId` almacenado en `data-id` del botón
        var cajaId = $(this).data('id'); // Obtén el ID desde el botón
        if (!cajaId) {
            Swal.fire({
                title: 'Error',
                text: 'ID de caja no encontrado',
                icon: 'error'
            });
            return;
        }

        // Recoger los datos del formulario
        var fecha_apertura = $('#fechaapertura').val().trim();
        var monto_apertura = $('#montoapertura').val().trim();
        var monto_cierre = $('#montocierre').val().trim();
        var fecha_cierre = $('#fechacierre').val().trim();
        var apertura = $('#apertura').val().trim();

        // Verificamos si algún campo obligatorio está vacío
        if (fecha_apertura === '' || monto_apertura === '' || monto_cierre === '' || fecha_cierre === '' || apertura === '') {
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
            url: '../admin/consultas/actualizarCaja.php', // Ruta al archivo PHP que manejará el update
            data: {
                id: cajaId,
                fecha_apertura: fecha_apertura,
                monto_apertura: monto_apertura,
                monto_cierre: monto_cierre,
                fecha_cierre: fecha_cierre,
                apertura: apertura
            },
            success: function(data) {
                // Verificamos la respuesta del servidor
                const response = JSON.parse(data);
                if (response.success) {
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Caja actualizada correctamente',
                        timer: 1500,
                        showConfirmButton: false,
                        icon: 'success'
                    }).then(function() {
                        // Cerrar el modal y recargar la página o realizar otras acciones
                        $('#modalEditarCaja').hide();
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
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al actualizar los datos de la Caja.',
                    icon: 'error'
                });
            }
        });
    });

    function confirmDelete(caja_id, fecha_apertura) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `Esta acción eliminará la caja del dia ${fecha_apertura}. ¿Estás seguro de eliminar a ${fecha_apertura}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            confirmButtonColor: '#3085d6',
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#C4044A'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the delete URL with the ID
                window.location.href = '../admin/consultas/eliminarcaja.php?id=' + caja_id;
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