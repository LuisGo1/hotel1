<?php
include "../admin/includes/header.php";
?>

<!-- Contenido principal -->
<div class="main-content">
    <h1>Check In / Check Out</h1>

    <!-- Tabla de Check-In / Check-Out -->
    <table id="tablaCheckInOut" class="display">
        <thead>
            <tr>
                <th>Check ID</th>
                <th>Fecha Check-In</th>
                <th>Fecha Check-Out</th>
                <th>Numero de Reserva</th>
                <th>Nombre del Cliente</th>
                <th>Estado</th>
                <th>Numero de Habitacion</th>
                <th>Cantidad de Dias</th>
                <th>Numero de empleado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="checkInOutData">
        <?php
            include("../conecction/db.php");

            // Modificar la consulta para hacer un JOIN con la tabla habitaciones
            $consulta = $conexion->query("
                SELECT 
                    check_in_out.check_id, 
                    check_in_out.fecha_check_in, 
                    check_in_out.fecha_check_out, 
                    check_in_out.id_reserva, 
                    check_in_out.id_cliente, 
                    clientes.nombre_cliente, 
                    check_in_out.estado, 
                    habitaciones.numero_habitacion,  -- Obtener el numero de la habitacion
                    check_in_out.cant_dias, 
                    check_in_out.id_empleado 
                FROM 
                    check_in_out
                JOIN 
                    clientes ON check_in_out.id_cliente = clientes.cliente_id
                JOIN
                    habitaciones ON check_in_out.id_habitacion = habitaciones.cuarto_id  -- JOIN con la tabla de habitaciones
            ");

            while ($fila = $consulta->fetch_assoc()) {
                echo "<tr data-check-id='" . htmlspecialchars($fila['check_id']) . "'>";
                echo "<td>" . htmlspecialchars($fila['check_id']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['fecha_check_in']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['fecha_check_out']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['id_reserva']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['nombre_cliente']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['estado']) . "</td>";
                // Mostrar el numero de habitacion en lugar del id_habitacion
                echo "<td>" . htmlspecialchars($fila['numero_habitacion']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['cant_dias']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['id_empleado']) . "</td>";
               
                echo "<td style='display: flex; justify-content: center; align-items: center; height: 60px; gap: 2px;' >";
                echo "<button class='btn btnEditar' data-check-id='" . htmlspecialchars($fila['check_id']) . "'>";
                echo "<i class='fa fa-edit' style='margin-right: 5px;'></i></button>";
                echo "<button class='btn btnEliminar'>";
                echo "<i class='fa fa-trash' style='margin-right: 5px;' aria-hidden='true'></i></button>";
                echo "</div>";
                
                echo "</td>";
                echo "</tr>";
            }

            $conexion->close();
        ?>
        </tbody>
    </table>

    
    <!-- Botón para agregar nuevo registro -->
    <button id="btnNuevoCheckInOut">Agregar Nuevo Registro</button>

    <!-- Modal para agregar nuevo registro -->
    <div id="modalCheckInOut" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Agregar Nuevo Registro</h2>
            <form id="formNuevoCheckInOut">
                <label for="fechaCheckIn">Fecha Check-In:</label>
                <input type="date" id="fechaCheckIn" required />
                <label for="fechaCheckOut">Fecha Check-Out:</label>
                <input type="date" id="fechaCheckOut" required />
                <label for="numeroReserva">Numero de Reserva:</label>
                <input type="number" id="numeroReserva" required />
                <label for="numeroCliente">Numero de Cliente:</label>
                <input type="number" id="numeroCliente" required />
                <label for="estadoCheckInOut">Estado:</label>
                <select id="estadoCheckInOut" required>
                    <option value="disponible">Disponible</option>
                    <option value="ocupada">Ocupada</option>
                    <option value="reservada">Reservada</option>
                    <option value="mantenimiento">Mantenimiento</option>
                    <option value="limpieza">Limpieza</option>
                </select>
                <label for="numeroHabitacion">Numero de Habitacion:</label>
                <input type="number" id="numeroHabitacion" required />
                <label for="cantDias">Cantidad de Dias:</label>
                <input type="number" id="cantDias" required />
                <label for="numeroEmpleado">Numero de Empleado:</label>
                <input type="number" id="numeroEmpleado" required />
                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>

    <!-- modal de edicion -->
    <div id="modalEditarCheckInOut" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Editar Registro</h2>
            <form id="formEditarCheckInOut">
                <input type="hidden" id="editCheckId" />
                <label for="editFechaCheckIn">Fecha Check-In:</label>
                <input type="date" id="editFechaCheckIn" required />
                
                <label for="editFechaCheckOut">Fecha Check-Out:</label>
                <input type="date" id="editFechaCheckOut" required />
                
                <label for="editNumeroReserva">Número de Reserva:</label>
                <input type="number" id="editNumeroReserva" required />
                
                <label for="editNumeroCliente">Número de Cliente:</label>
                <input type="number" id="editNumeroCliente" required />
                
                <label for="editEstadoCheckInOut">Estado:</label>
                <select id="editEstadoCheckInOut" required>
                    <option value="disponible">Disponible</option>
                    <option value="ocupada">Ocupada</option>
                    <option value="reservada">Reservada</option>
                    <option value="mantenimiento">Mantenimiento</option>
                    <option value="limpieza">Limpieza</option>
                </select>
                
                <label for="editNumeroHabitacion">Número de Habitación:</label>
                <input type="number" id="editNumeroHabitacion" required />
                
                <label for="editCantDias">Cantidad de Días:</label>
                <input type="number" id="editCantDias" required />
                
                <label for="editNumeroEmpleado">Número de Empleado:</label>
                <input type="number" id="editNumeroEmpleado" required />
                
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>

</div>

</div>

<!-- JavaScript para el modal y la solicitud AJAX -->

<script>
// Abrir y cerrar el modal
const modal = document.getElementById("modalCheckInOut");
const btnNuevoCheckInOut = document.getElementById("btnNuevoCheckInOut");
const spanClose = document.getElementsByClassName("close")[0];

btnNuevoCheckInOut.onclick = () => {
    modal.style.display = "block";
};

spanClose.onclick = () => {
    modal.style.display = "none";
};

window.onclick = (event) => {
    if (event.target === modal) {
        modal.style.display = "none";
    }
};

// Manejo de envío de formulario AJAX
// Manejo de envío de formulario AJAX
document.getElementById("formNuevoCheckInOut").addEventListener("submit", function (e) {
    e.preventDefault();

    // Capturar los datos del formulario
    const fechaCheckIn = document.getElementById("fechaCheckIn").value;
    const fechaCheckOut = document.getElementById("fechaCheckOut").value;
    const numeroReserva = document.getElementById("numeroReserva").value;
    const numeroCliente = document.getElementById("numeroCliente").value;
    const estado = document.getElementById("estadoCheckInOut").value;
    const numeroHabitacion = document.getElementById("numeroHabitacion").value;  // Número de habitación ingresado
    const cantDias = document.getElementById("cantDias").value;
    const numeroEmpleado = document.getElementById("numeroEmpleado").value;

    // Usar SweetAlert2 para mostrar la alerta de confirmación
    Swal.fire({
        title: "¿Estás seguro de que deseas agregar este registro?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Sí, agregar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            // Realizar una solicitud AJAX para obtener el ID de la habitación
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "getHabitacionId.php", true); // Archivo PHP que devuelve el ID
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            // Añadir un console.log para depurar la solicitud AJAX
            console.log("Enviando solicitud para obtener ID de habitación...");

            xhr.onload = function () {
                console.log("Respuesta de getHabitacionId.php recibida: ", xhr.responseText);

                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Si la habitación se encontró, usar el ID de la habitación
                        const idHabitacion = response.id_habitacion;

                        // Ahora realizar la solicitud AJAX para agregar el registro
                        const xhrAgregar = new XMLHttpRequest();
                        xhrAgregar.open("POST", "agregarCheckInOut.php", true);
                        xhrAgregar.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                        // Añadir un console.log para depurar la solicitud AJAX de agregar
                        console.log("Enviando solicitud para agregar nuevo registro...");

                        xhrAgregar.onload = function () {
                            console.log("Respuesta de agregarCheckInOut.php recibida: ", xhrAgregar.responseText);

                            if (xhrAgregar.status === 200) {
                                const responseAgregar = JSON.parse(xhrAgregar.responseText);
                                if (responseAgregar.success) {
                                    // Añadir el nuevo registro a la tabla sin recargar la página
                                    const newRow = `
                                        <tr data-check-id="${responseAgregar.check_id}">
                                            <td>${responseAgregar.check_id}</td>
                                            <td>${fechaCheckIn}</td>
                                            <td>${fechaCheckOut}</td>
                                            <td>${numeroReserva}</td>
                                            <td>${numeroCliente}</td>
                                            <td>${estado}</td>
                                            <td>${numeroHabitacion}</td>
                                            <td>${cantDias}</td>
                                            <td>${numeroEmpleado}</td>
                                            <td>
                                                <button class='btnEditar' onclick='editarCheck(${responseAgregar.check_id})'><i class='fa fa-edit'></i></button>
                                                <button class='btnEliminar' onclick='eliminarCheck(${responseAgregar.check_id})'><i class='fa fa-trash' aria-hidden='true'></i></button>
                                            </td>
                                        </tr>
                                    `;
                                    document.getElementById("checkInOutData").insertAdjacentHTML("beforeend", newRow);
                                    modal.style.display = "none";

                                    // Mostrar mensaje de éxito con SweetAlert2
                                    Swal.fire("Registro Agregado", "El registro se ha agregado correctamente.", "success");
                                } else {
                                    // Mostrar mensaje de error con SweetAlert2
                                    Swal.fire("Error", "Error al agregar el registro: " + responseAgregar.message, "error");
                                }
                            } else {
                                // Mostrar mensaje de error con SweetAlert2 si falla la solicitud AJAX
                                Swal.fire("Error", "Error en la solicitud AJAX.", "error");
                            }
                        };

                        // Enviar los datos por AJAX para agregar el registro
                        xhrAgregar.send(`fecha_check_in=${encodeURIComponent(fechaCheckIn)}&fecha_check_out=${encodeURIComponent(fechaCheckOut)}&id_reserva=${encodeURIComponent(numeroReserva)}&id_cliente=${encodeURIComponent(numeroCliente)}&estado=${encodeURIComponent(estado)}&id_habitacion=${encodeURIComponent(idHabitacion)}&cant_dias=${encodeURIComponent(cantDias)}&id_empleado=${encodeURIComponent(numeroEmpleado)}`);
                    } else {
                        // Si no se encuentra la habitación, mostrar error
                        Swal.fire("Error", "No se encontró el número de habitación.", "error");
                    }
                } else {
                    // Mostrar mensaje de error con SweetAlert2 si falla la solicitud AJAX
                    Swal.fire("Error", "Error en la solicitud AJAX.", "error");
                }
            };

            // Enviar el número de habitación para obtener el ID
            xhr.send(`numero_habitacion=${encodeURIComponent(numeroHabitacion)}`);
        }
    });
});

</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Manejar la edición de registros
    document.querySelectorAll(".btnEditar").forEach(function (button) {
        button.addEventListener("click", function () {
            const row = this.closest("tr");
            const checkId = row.getAttribute("data-check-id");

            // Prellenar el formulario del modal con los datos de la fila
            document.getElementById("editCheckId").value = checkId;
            document.getElementById("editFechaCheckIn").value = row.children[1].textContent;
            document.getElementById("editFechaCheckOut").value = row.children[2].textContent;
            document.getElementById("editNumeroReserva").value = row.children[3].textContent;
            document.getElementById("editNumeroCliente").value = row.children[4].textContent;
            document.getElementById("editEstadoCheckInOut").value = row.children[5].textContent;
            document.getElementById("editNumeroHabitacion").value = row.children[6].textContent;
            document.getElementById("editCantDias").value = row.children[7].textContent;
            document.getElementById("editNumeroEmpleado").value = row.children[8].textContent;

            // Mostrar el modal de edición
            document.getElementById("modalEditarCheckInOut").style.display = "block";
        });
    });

    // Cerrar el modal de edición
    document.querySelector("#modalEditarCheckInOut .close").onclick = function () {
        document.getElementById("modalEditarCheckInOut").style.display = "none";
    };
});

document.addEventListener("DOMContentLoaded", function () {
    // Manejar la edición de registros
    document.querySelectorAll(".btnEditar").forEach(function (button) {
        button.addEventListener("click", function () {
            const row = this.closest("tr");
            const checkId = row.getAttribute("data-check-id");

            // Prellenar el formulario del modal con los datos de la fila
            document.getElementById("editCheckId").value = checkId;
            document.getElementById("editFechaCheckIn").value = row.children[1].textContent;
            document.getElementById("editFechaCheckOut").value = row.children[2].textContent;
            document.getElementById("editNumeroReserva").value = row.children[3].textContent;
            document.getElementById("editNumeroCliente").value = row.children[4].textContent;
            document.getElementById("editEstadoCheckInOut").value = row.children[5].textContent;
            document.getElementById("editNumeroHabitacion").value = row.children[6].textContent; // Número de habitación
            document.getElementById("editCantDias").value = row.children[7].textContent;
            document.getElementById("editNumeroEmpleado").value = row.children[8].textContent;

            // Mostrar el modal de edición
            document.getElementById("modalEditarCheckInOut").style.display = "block";
        });
    });

    // Cerrar el modal de edición
    document.querySelector("#modalEditarCheckInOut .close").onclick = function () {
        document.getElementById("modalEditarCheckInOut").style.display = "none";
    };
});

document.getElementById("formEditarCheckInOut").addEventListener("submit", function (e) {
    e.preventDefault();

    // Capturar los datos del formulario
    const checkId = document.getElementById("editCheckId").value;
    const fechaCheckIn = document.getElementById("editFechaCheckIn").value;
    const fechaCheckOut = document.getElementById("editFechaCheckOut").value;
    const numeroReserva = document.getElementById("editNumeroReserva").value;
    const numeroCliente = document.getElementById("editNumeroCliente").value;
    const estado = document.getElementById("editEstadoCheckInOut").value;
    const numeroHabitacion = document.getElementById("editNumeroHabitacion").value; // Número de habitación
    const cantDias = document.getElementById("editCantDias").value;
    const numeroEmpleado = document.getElementById("editNumeroEmpleado").value;

    // Realizar una solicitud AJAX para obtener el ID de la habitación
    fetch("getHabitacionId.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `numero_habitacion=${encodeURIComponent(numeroHabitacion)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Si se encontró el ID de la habitación, continuamos con el envío de los datos para actualizar el registro
            const idHabitacion = data.id_habitacion;

            // Enviar datos por AJAX para actualizar el registro
            return fetch("editarCheckInOut.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `check_id=${encodeURIComponent(checkId)}&fecha_check_in=${encodeURIComponent(fechaCheckIn)}&fecha_check_out=${encodeURIComponent(fechaCheckOut)}&id_reserva=${encodeURIComponent(numeroReserva)}&id_cliente=${encodeURIComponent(numeroCliente)}&estado=${encodeURIComponent(estado)}&id_habitacion=${encodeURIComponent(idHabitacion)}&cant_dias=${encodeURIComponent(cantDias)}&id_empleado=${encodeURIComponent(numeroEmpleado)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar alerta de éxito con SweetAlert
                    Swal.fire("Éxito", "Registro actualizado correctamente.", "success");

                    // Actualizar la fila correspondiente en la tabla
                    const row = document.querySelector(`tr[data-check-id='${checkId}']`);
                    if (row) {
                        row.children[1].textContent = fechaCheckIn;
                        row.children[2].textContent = fechaCheckOut;
                        row.children[3].textContent = numeroReserva;
                        row.children[4].textContent = numeroCliente;
                        row.children[5].textContent = estado;
                        row.children[6].textContent = numeroHabitacion; // Número de habitación
                        row.children[7].textContent = cantDias;
                        row.children[8].textContent = numeroEmpleado;
                    }

                    // Cerrar el modal de edición
                    document.getElementById("modalEditarCheckInOut").style.display = "none";
                } else {
                    // Mostrar alerta de error con SweetAlert
                    Swal.fire("Error", "Error al actualizar el registro: " + data.message, "error");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                // Mostrar alerta de error de solicitud con SweetAlert
                Swal.fire("Error", "Error en la solicitud.", "error");
            });
        } else {
            // Si no se encuentra la habitación, mostrar error
            Swal.fire("Error", "No se encontró el número de habitación.", "error");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        // Mostrar alerta de error si falla la solicitud para obtener el ID de la habitación
        Swal.fire("Error", "Error al obtener el ID de la habitación.", "error");
    });
});

</script>
<!-- Incluir SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    // Manejar la eliminación de registros
    document.querySelectorAll(".btnEliminar").forEach(function (button) {
        button.addEventListener("click", function () {
            const row = this.closest("tr");
            const checkId = row.getAttribute("data-check-id");

            // Usar SweetAlert para la confirmación
            Swal.fire({
                title: `¿Estás seguro de que deseas eliminar el registro con ID ${checkId}?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, eliminar!",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar solicitud AJAX para eliminar el registro
                    fetch("eliminarCheckInOut.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                        },
                        body: `check_id=${encodeURIComponent(checkId)}`,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Mostrar alerta de éxito
                            Swal.fire({
                                title: "¡Eliminado!",
                                text: "Registro eliminado correctamente.",
                                icon: "success"
                            });
                            // Eliminar la fila de la tabla
                            row.remove();
                        } else {
                            // Mostrar alerta de error
                            Swal.fire({
                                title: "Error",
                                text: "Error al eliminar el registro: " + data.message,
                                icon: "error"
                            });
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        Swal.fire({
                            title: "Error",
                            text: "Error en la solicitud.",
                            icon: "error"
                        });
                    });
                }
            });
        });
    });
});


</script>

<?php include "../admin/includes/footer.php"; ?>