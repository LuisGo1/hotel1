<?php
include "../user/includes/header.php";
?>
<div class="bodycieCrrecaja">
    <div class="cierre-caja-container">
        <h2>Cierre de Caja</h2>
        <div class="form-group">
            <label for="fechaCierre">Fecha de Cierre</label>
            <input type="date" id="fechaCierre" name="fechaCierre" value="<?= date('Y-m-d') ?>" readonly>
        </div>
        <div class="form-group">
            <label for="montoCierre">Monto de Cierre</label>
            <input type="number" id="montoCierre" name="montoCierre" placeholder="0.00">
        </div>
        <button class="submit-btn" id="cerrarBtn" disabled>Cerrar</button>
    </div>

    <!-- Tabla de Resumen -->
    <div class="tabla-resumen">
        <table id="resumenTable" class="display">
            <thead>
                <tr>
                    <th>ID Caja</th>
                    <th>Fecha Apertura</th>
                    <th>Monto Apertura</th>
                    <th>Fecha Cierre</th>
                    <th>Monto Cierre</th>
                    <th>Total Ingreso Día</th>
                    <th>Total Egreso Día</th>
                    <th>Saldo Final</th>
                    <th>Estado</th>
                    <th>Empleado ID</th>
                </tr>
            </thead>
            <tbody>
                <!-- Aquí se llenará dinámicamente la tabla -->
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Inicializa DataTables
    $(document).ready(function() {
        $('#resumenTable').DataTable();
    });

    // Función para cargar los datos de la tabla caja_diaria
    function cargarCajas() {
        $.ajax({
            url: 'get_caja_backend.php', // Ruta al archivo PHP para obtener las cajas
            type: 'GET',
            success: function(response) {
                console.log(response); // Esto te ayudará a ver el formato de la respuesta
                try {
                    const data = JSON.parse(response);
                    if (data.success) {
                        const tbody = $("#resumenTable tbody");
                        tbody.empty(); // Limpiar la tabla antes de agregar nuevos datos

                        data.data.forEach(function(caja) {
                            const tr = $("<tr></tr>");
                            tr.append("<td>" + caja.caja_id + "</td>");
                            tr.append("<td>" + caja.fecha_apertura + "</td>");
                            tr.append("<td>" + caja.monto_apertura + "</td>");
                            tr.append("<td>" + (caja.fecha_cierre ? caja.fecha_cierre : "No cerrado") + "</td>");
                            tr.append("<td>" + caja.monto_cierre + "</td>");
                            tr.append("<td>" + caja.total_ingreso_dia + "</td>");
                            tr.append("<td>" + caja.total_egreso_dia + "</td>");
                            tr.append("<td>" + caja.saldo_final + "</td>");
                            tr.append("<td>" + caja.estado + "</td>");
                            tr.append("<td>" + caja.empleado_id + "</td>");
                            tbody.append(tr); // Agregar la fila a la tabla
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.error,
                            icon: 'error'
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        title: 'Error',
                        text: 'La respuesta no es válida. Intenta de nuevo.',
                        icon: 'error'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error al obtener los datos.',
                    icon: 'error'
                });
            }
        });
    }

    // Cargar las cajas al cargar la página
    cargarCajas();

    // Habilitar el botón si el monto es válido
    const montoCierreInput = document.getElementById("montoCierre");
    const cerrarBtn = document.getElementById("cerrarBtn");

    montoCierreInput.addEventListener("input", function() {
        cerrarBtn.disabled = isNaN(montoCierreInput.value) || montoCierreInput.value <= 0;
    });

    // Manejar el cierre de caja con AJAX
    cerrarBtn.addEventListener("click", function() {
        const montoCierre = parseFloat(montoCierreInput.value);

        if (isNaN(montoCierre) || montoCierre <= 0) {
            Swal.fire({
                title: 'Error',
                text: 'Por favor, ingrese un monto válido.',
                icon: 'error',
            });
            return;
        }

        $.ajax({
            url: "cierre_backend.php", // Asegúrate de que la ruta sea correcta
            type: "POST",
            data: { montoCierre: montoCierre }, // Asegúrate de que el valor se pase correctamente
            success: function(response) {
                console.log(response); // Revisa la respuesta del servidor
                const data = JSON.parse(response);
                if (data.success) {
                    Swal.fire({
                        title: 'Éxito',
                        text: data.message,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload(); // Refrescar la página para actualizar el estado
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.error,
                        icon: 'error'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error al procesar la solicitud.',
                    icon: 'error'
                });
            }
        });
    });
</script>
</body>
</html>
