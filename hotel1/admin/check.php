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

            // Modificar la consulta para hacer un JOIN con la tabla clientes
            $consulta = $conexion->query("
                SELECT 
                    check_in_out.check_id, 
                    check_in_out.fecha_check_in, 
                    check_in_out.fecha_check_out, 
                    check_in_out.id_reserva, 
                    check_in_out.id_cliente, 
                    clientes.nombre_cliente, 
                    check_in_out.estado, 
                    check_in_out.id_habitacion, 
                    check_in_out.cant_dias, 
                    check_in_out.id_empleado 
                FROM 
                    check_in_out
                JOIN 
                    clientes ON check_in_out.id_cliente = clientes.cliente_id
            ");

            while ($fila = $consulta->fetch_assoc()) {
                echo "<tr data-check-id='" . htmlspecialchars($fila['check_id']) . "'>";
                echo "<td>" . htmlspecialchars($fila['check_id']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['fecha_check_in']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['fecha_check_out']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['id_reserva']) . "</td>";
                // Cambiar para mostrar el nombre del cliente en lugar del id_cliente
                echo "<td>" . htmlspecialchars($fila['nombre_cliente']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['estado']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['id_habitacion']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['cant_dias']) . "</td>";
                echo "<td>" . htmlspecialchars($fila['id_empleado']) . "</td>";
                echo "<td>";
                echo "<button class='btnEditar' data-check-id='" . htmlspecialchars($fila['check_id']) . "'><i class='fa fa-edit'></i></button>";
                echo "<button class='btnEliminar'><i class='fa fa-trash' aria-hidden='true'></i></button>";
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
document.getElementById("formNuevoCheckInOut").addEventListener("submit", function (e) {
    e.preventDefault();

    // Capturar los datos del formulario
    const fechaCheckIn = document.getElementById("fechaCheckIn").value;
    const fechaCheckOut = document.getElementById("fechaCheckOut").value;
    const numeroReserva = document.getElementById("numeroReserva").value;
    const numeroCliente = document.getElementById("numeroCliente").value;
    const estado = document.getElementById("estadoCheckInOut").value;
    const numeroHabitacion = document.getElementById("numeroHabitacion").value;
    const cantDias = document.getElementById("cantDias").value;
    const numeroEmpleado = document.getElementById("numeroEmpleado").value;

    // Enviar datos por AJAX
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "agregarCheckInOut.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                // Añadir el nuevo registro a la tabla sin recargar la página
                const newRow = `
                    <tr data-check-id="${response.check_id}">
                        <td>${response.check_id}</td>
                        <td>${fechaCheckIn}</td>
                        <td>${fechaCheckOut}</td>
                        <td>${numeroReserva}</td>
                        <td>${numeroCliente}</td>
                        <td>${estado}</td>
                        <td>${numeroHabitacion}</td>
                        <td>${cantDias}</td>
                        <td>${numeroEmpleado}</td>
                        <td>
                            <button class='btnEditar' onclick='editarCheck(${response.check_id})'>Editar</button>
                            <button class='btnEliminar' onclick='eliminarCheck(${response.check_id})'>Eliminar</button>
                        </td>
                    </tr>
                `;
                document.getElementById("checkInOutData").insertAdjacentHTML("beforeend", newRow);
                modal.style.display = "none";
            } else {
                alert("Error al agregar el registro: " + response.message);
            }
        } else {
            alert("Error en la solicitud AJAX");
        }
    };

    xhr.send(`fecha_check_in=${encodeURIComponent(fechaCheckIn)}&fecha_check_out=${encodeURIComponent(fechaCheckOut)}&id_reserva=${encodeURIComponent(numeroReserva)}&id_cliente=${encodeURIComponent(numeroCliente)}&estado=${encodeURIComponent(estado)}&id_habitacion=${encodeURIComponent(numeroHabitacion)}&cant_dias=${encodeURIComponent(cantDias)}&id_empleado=${encodeURIComponent(numeroEmpleado)}`);
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

document.getElementById("formEditarCheckInOut").addEventListener("submit", function (e) {
    e.preventDefault();

    // Capturar los datos del formulario
    const checkId = document.getElementById("editCheckId").value;
    const fechaCheckIn = document.getElementById("editFechaCheckIn").value;
    const fechaCheckOut = document.getElementById("editFechaCheckOut").value;
    const numeroReserva = document.getElementById("editNumeroReserva").value;
    const numeroCliente = document.getElementById("editNumeroCliente").value;
    const estado = document.getElementById("editEstadoCheckInOut").value;
    const numeroHabitacion = document.getElementById("editNumeroHabitacion").value;
    const cantDias = document.getElementById("editCantDias").value;
    const numeroEmpleado = document.getElementById("editNumeroEmpleado").value;

    // Enviar datos por AJAX
    fetch("editarCheckInOut.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `check_id=${encodeURIComponent(checkId)}&fecha_check_in=${encodeURIComponent(fechaCheckIn)}&fecha_check_out=${encodeURIComponent(fechaCheckOut)}&id_reserva=${encodeURIComponent(numeroReserva)}&id_cliente=${encodeURIComponent(numeroCliente)}&estado=${encodeURIComponent(estado)}&id_habitacion=${encodeURIComponent(numeroHabitacion)}&cant_dias=${encodeURIComponent(cantDias)}&id_empleado=${encodeURIComponent(numeroEmpleado)}`,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Registro actualizado correctamente.");

            // Actualizar la fila correspondiente en la tabla
            const row = document.querySelector(`tr[data-check-id='${checkId}']`);
            row.children[1].textContent = fechaCheckIn;
            row.children[2].textContent = fechaCheckOut;
            row.children[3].textContent = numeroReserva;
            row.children[4].textContent = numeroCliente;
            row.children[5].textContent = estado;
            row.children[6].textContent = numeroHabitacion;
            row.children[7].textContent = cantDias;
            row.children[8].textContent = numeroEmpleado;

            // Cerrar el modal de edición
            document.getElementById("modalEditarCheckInOut").style.display = "none";
        } else {
            alert("Error al actualizar el registro: " + data.message);
        }
    })
    .catch(error => {
        console.error("Error:", error);
        alert("Error en la solicitud.");
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