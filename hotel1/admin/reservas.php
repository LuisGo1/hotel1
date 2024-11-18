<?php
include "../admin/includes/header.php";
?>

    <div class="main-content">
        <h1>Reservas</h1>

        <table id="tablaCheckInOut" class="display">
            <thead>
                <tr>
                    <th>Numero de Reserva</th>
                    <th>Numero de Cliente</th>
                    <th>Numero de Cuarto</th>
                    <th>Numero de Huespedes </th>
                    <th>Comentarios</th>
                    <th>Estado del Cuarto</th>
                    <th>Monto Total</th>
                    <th>Fecha de Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="reservasData">
                <?php
                    include("../conecction/db.php");
                    
                    // Consulta para obtener los datos de la reserva junto con el número de habitación
                    $consulta = $conexion->query("
                        SELECT reservas.reserva_id, reservas.id_cliente, reservas.cuarto_id, 
                               reservas.num_huespedes, reservas.comentarios, reservas.estado, 
                               reservas.monto_total, reservas.fecha_registro, habitaciones.numero_habitacion 
                        FROM reservas
                        JOIN habitaciones ON reservas.cuarto_id = habitaciones.cuarto_id
                    ");
                    
                    while ($fila = $consulta->fetch_assoc()) {
                        echo "<tr data-reserva-id='" . htmlspecialchars($fila['reserva_id']) . "'>";
                        echo "<td>" . htmlspecialchars($fila['reserva_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['id_cliente']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['numero_habitacion']) . "</td>"; // Cambiado para mostrar el número de habitación
                        echo "<td>" . htmlspecialchars($fila['num_huespedes']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['comentarios']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['estado']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['monto_total']) . "</td>";
                        echo "<td>" . htmlspecialchars($fila['fecha_registro']) . "</td>";
                        
                        
                        echo "<td style='display: flex; justify-content: center; align-items: center; height: 60px; gap: 2px;' >";
                        echo "<button class='btnEditar' data-reserva-id='" . htmlspecialchars($fila['reserva_id']) . "'><i class='fa fa-edit'></i></button>";
                        echo "<button class='btnEliminar' data-reserva-id='" . htmlspecialchars($fila['reserva_id']) . "'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    $conexion->close();
                ?>
            </tbody>
        </table>

        <button id="btnNuevaReserva">Nueva Reserva</button>

        <!-- Modal para agregar nueva reserva -->
        <div id="modalReserva" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Agregar Reserva</h2>
                <form id="formNuevaReserva">
                    <label for="clienteid">Numero de Cliente:</label>
                    <input type="number" id="clienteid" required />
                    <label for="cuartoid">Numero de Cuarto:</label>
                    <input type="number" id="cuartoid" required />
                    <label for="numerohuespedes">Numero de Huespedes:</label>
                    <input type="number" id="numerohuespedes" required />
                    <label for="comentarios">Comentarios:</label>
                    <input type="text" id="comentarios" required />
                    <label for="estado">Estado:</label>
                    <select id="estado" name="estado" required>
                        <option value="confirmada">Confirmada</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="cancelada">Cancelada</option>
                    </select>

                    <label for="montototal">Monto Total:</label>
                    <input type="number" id="montototal" required />
                    <label for="fecha">Fecha de Registro:</label>
                    <input type="date" id="fecha" required />
                    <button type="submit">Guardar</button>
                </form>
            </div>
        </div>

        <!-- Modal para editar reserva -->
        <div id="modalEditarReserva" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Editar Reserva</h2>
                <form id="formEditarReserva">
                    <input type="hidden" id="editReservaId" /> <!-- ID de reserva oculta -->
                    <label for="editClienteid">Numero de Cliente:</label>
                    <input type="number" id="editClienteid" required />
                    <label for="editNumeroHabitacion">Numero de Cuarto:</label>
                    <input type="number" id="editNumeroHabitacion" required />
                    <label for="editNumerohuespedes">Numero de Huespedes:</label>
                    <input type="number" id="editNumerohuespedes" required />
                    <label for="editComentarios">Comentarios:</label>
                    <input type="text" id="editComentarios" required />
                    <label for="editEstado">Estado:</label>
                    <select id="editEstado" name="editEstado" required>
                        <option value="confirmada">Confirmada</option>
                        <option value="pendiente">Pendiente</option>
                        <option value="cancelada">Cancelada</option>
                    </select>

                    <label for="editMontototal">Monto Total:</label>
                    <input type="number" id="editMontototal" required />
                    <label for="editFecha">Fecha de Registro:</label>
                    <input type="date" id="editFecha" required />
                    <button type="submit">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
    const modalReserva = document.getElementById("modalReserva");
    const btnNuevaReserva = document.getElementById("btnNuevaReserva");
    var span = document.getElementsByClassName("close")[0];

    btnNuevaReserva.onclick = function() {
        modalReserva.style.display = "block";
    };
    span.onclick = function() {
        modalReserva.style.display = "none";
    };
    window.onclick = function(event) {
        if (event.target == modalReserva) {
            modalReserva.style.display = "none"
        }
    }
    
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Obtener los elementos del modal de edición
    const modalEditarReserva = document.getElementById("modalEditarReserva");
    const closeEditar = modalEditarReserva.querySelector(".close");

    // Cerrar el modal de edición
    closeEditar.onclick = function() {
        modalEditarReserva.style.display = "none";
    };

    // Función para abrir el modal de edición con los datos actuales
    document.querySelectorAll('.btnEditar').forEach(button => {
        button.addEventListener('click', function() {
            const reservaId = this.getAttribute('data-reserva-id');
            
            // Obtener la fila que contiene los datos de la reserva
            const fila = document.querySelector(`tr[data-reserva-id="${reservaId}"]`);
            const datos = fila.querySelectorAll('td');

            // Rellenar los campos del formulario de edición con los datos existentes
            document.getElementById("editReservaId").value = reservaId;
            document.getElementById("editClienteid").value = datos[1].innerText;
            document.getElementById("editNumeroHabitacion").value = datos[2].innerText; // Número de habitación
            document.getElementById("editNumerohuespedes").value = datos[3].innerText;
            document.getElementById("editComentarios").value = datos[4].innerText;
            document.getElementById("editEstado").value = datos[5].innerText;
            document.getElementById("editMontototal").value = datos[6].innerText;
            document.getElementById("editFecha").value = datos[7].innerText;

            // Mostrar el modal de edición
            modalEditarReserva.style.display = "block";
        });
    });

    // Cerrar modal si se hace clic fuera del contenido del modal
    window.onclick = function(event) {
        if (event.target == modalEditarReserva) {
            modalEditarReserva.style.display = "none";
        }
    }
});

document.getElementById("formEditarReserva").addEventListener("submit", function(event) {
    event.preventDefault(); // Evitar la recarga del formulario

    // Capturamos los datos del formulario de edición
    const reservaId = document.getElementById("editReservaId").value;
    const clienteid = document.getElementById("editClienteid").value;
    const numeroHabitacion = document.getElementById("editNumeroHabitacion").value; // Número de habitación ingresado
    const numerohuespedes = document.getElementById("editNumerohuespedes").value;
    const comentarios = document.getElementById("editComentarios").value;
    const estado = document.getElementById("editEstado").value;
    const montototal = document.getElementById("editMontototal").value;
    const fecha = document.getElementById("editFecha").value;

    // Buscar el ID de la habitación a partir del número de habitación
    fetch('obtenerCuartoId.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `numero_habitacion=${numeroHabitacion}` // Enviar el número de habitación
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const cuartoid = data.cuarto_id; // Obtener el ID de la habitación

            // Ahora enviar los datos con el ID de la habitación
            fetch('editarReserva.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `reserva_id=${reservaId}&clienteid=${clienteid}&cuartoid=${cuartoid}&numerohuespedes=${numerohuespedes}&comentarios=${comentarios}&estado=${estado}&montototal=${montototal}&fecha=${fecha}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar alerta de éxito con SweetAlert
                    Swal.fire("Éxito", "Reserva editada correctamente.", "success");

                    // Actualizar la tabla si la edición fue exitosa
                    const fila = document.querySelector(`tr[data-reserva-id="${reservaId}"]`);
                    if (fila) {
                        fila.querySelectorAll('td')[1].innerText = clienteid;
                        fila.querySelectorAll('td')[2].innerText = numeroHabitacion; // Mostrar número de habitación
                        fila.querySelectorAll('td')[3].innerText = numerohuespedes;
                        fila.querySelectorAll('td')[4].innerText = comentarios;
                        fila.querySelectorAll('td')[5].innerText = estado;
                        fila.querySelectorAll('td')[6].innerText = montototal;
                        fila.querySelectorAll('td')[7].innerText = fecha;
                    }

                    // Cerrar el modal de edición
                    modalEditarReserva.style.display = "none";
                } else {
                    // Mostrar alerta de error con SweetAlert
                    Swal.fire("Error", "Error al editar la reserva: " + data.error, "error");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Mostrar alerta de error de solicitud con SweetAlert
                Swal.fire("Error", "Error al editar la reserva.", "error");
            });
        } else {
            // Si no se encuentra el número de habitación
            Swal.fire("Error", "No se encontró el número de habitación.", "error");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire("Error", "Error al obtener el ID de la habitación.", "error");
    });
});

</script>
<!-- JavaScript para el modal y la solicitud AJAX -->

<script>
document.getElementById("formNuevaReserva").addEventListener("submit", function(event) {
    event.preventDefault(); // Evitar la recarga del formulario

    // Capturamos los datos del formulario
    const clienteid = document.getElementById("clienteid").value;
    const numerohabitacion = document.getElementById("cuartoid").value; // Ahora tomamos el número de habitación
    const numerohuespedes = document.getElementById("numerohuespedes").value;
    const comentarios = document.getElementById("comentarios").value;
    const estado = document.getElementById("estado").value;
    const montototal = document.getElementById("montototal").value;
    const fecha = document.getElementById("fecha").value;

    // Usar SweetAlert2 para mostrar la alerta de confirmación
    Swal.fire({
        title: "¿Estás seguro de que deseas agregar esta reserva?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Sí, agregar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            // Primero, obtenemos el ID de la habitación a partir del número de habitación
            fetch('getHabitacionId.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `numero_habitacion=${encodeURIComponent(numerohabitacion)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Si se encuentra el ID de la habitación, procedemos a enviar la reserva
                    const cuartoid = data.id_habitacion; // Usamos el ID de la habitación

                    // Realizamos la solicitud para agregar la reserva
                    fetch('agregarReserva.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `clienteid=${clienteid}&cuartoid=${cuartoid}&numerohuespedes=${numerohuespedes}&comentarios=${comentarios}&estado=${estado}&montototal=${montototal}&fecha=${fecha}`
                    })
                    .then(response => response.text())  // Cambia a text() temporalmente para depuración
                    .then(data => {
                        console.log('Respuesta del servidor:', data); // Muestra la respuesta completa
                        try {
                            const jsonData = JSON.parse(data);
                            if (jsonData.error) {
                                // Mostrar mensaje de error con SweetAlert2
                                Swal.fire("Error", jsonData.error, "error");
                            } else {
                                // Si la reserva se agrega correctamente, actualizamos la tabla
                                const tabla = document.getElementById("reservasData");
                                const nuevaFila = document.createElement("tr");

                                nuevaFila.setAttribute("data-reserva-id", jsonData.reserva_id);
                                nuevaFila.innerHTML = `
                                    <td>${jsonData.reserva_id}</td>
                                    <td>${jsonData.id_cliente}</td>
                                    <td>${jsonData.cuarto_id}</td>
                                    <td>${jsonData.num_huespedes}</td>
                                    <td>${jsonData.comentarios}</td>
                                    <td>${jsonData.estado}</td>
                                    <td>${jsonData.monto_total}</td>
                                    <td>${jsonData.fecha_registro}</td>
                                    <td>
                                        <button class='btnEditar' data-reserva-id='${jsonData.reserva_id}'><i class='fa fa-edit'></i></button>
                                        <button class='btnEliminar'><i class='fa fa-trash' aria-hidden='true'></i></button>
                                    </td>
                                `;

                                tabla.appendChild(nuevaFila);
                                modalReserva.style.display = "none";

                                // Mostrar mensaje de éxito con SweetAlert2
                                Swal.fire("Reserva Agregada", "La reserva se ha agregado correctamente.", "success");
                            }
                        } catch (e) {
                            console.error('Error al parsear JSON:', e);
                            Swal.fire("Error", "Hubo un problema al procesar la respuesta del servidor.", "error");
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire("Error", "Error en la solicitud al agregar la reserva.", "error");
                    });
                } else {
                    // Si no se encuentra la habitación con ese número
                    Swal.fire("Error", "No se encontró la habitación con el número ingresado.", "error");
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire("Error", "Error al obtener el ID de la habitación.", "error");
            });
        }
    });
});

</script>

<script>
    // Agregar evento a todos los botones de eliminar
    document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.btnEliminar').forEach(button => {
        button.addEventListener('click', function() {
            const reservaId = this.getAttribute('data-reserva-id');
            
            // Usar SweetAlert para la confirmación
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No podrás revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, eliminar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Enviar solicitud de eliminación al servidor
                    fetch('eliminarReserva.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `reserva_id=${reservaId}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Eliminar la fila de la tabla si la eliminación fue exitosa
                            const fila = document.querySelector(`tr[data-reserva-id="${reservaId}"]`);
                            if (fila) {
                                fila.remove();
                            }
                            // Mostrar alerta de eliminación exitosa
                            Swal.fire({
                                title: "¡Eliminado!",
                                text: "La reserva ha sido eliminada correctamente.",
                                icon: "success"
                            });
                        } else {
                            Swal.fire({
                                title: "Error",
                                text: "Error al eliminar la reserva: " + data.error,
                                icon: "error"
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: "Error",
                            text: "Ocurrió un error al eliminar la reserva.",
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