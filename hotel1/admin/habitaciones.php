<?php
include "../admin/includes/header.php"; // Continuar con el resto del código HTML
?>

<!-- Aquí empieza el código HTML, como ya lo tienes configurado -->
<div class="main-content">
    
    <h1>Habitaciones</h1>

    <table id="tablaCheckInOut" class="display">
        <thead>
            <tr>
                <th>Cuarto ID</th>
                <th >Numero de Habitacion</th>
                <th>Tipo de Habitación</th>
                <th >Descripcion</th>
                <th>Capacidad</th>
                <th >Precio Noche</th>
                <th>Estado</th>
                <th>Fecha de Registro</th>
                <th >Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include("../conecction/db.php");
                // Consulta para obtener las habitaciones ya registradas
                $consulta = $conexion->query("SELECT cuarto_id, numero_habitacion, tipo_habitacion, descripcion, capacidad, precio_noche, estado, fecha_registro FROM habitaciones");

                // Dentro del bucle while donde generas las filas de la tabla
                while ($fila = $consulta->fetch_assoc()) {
                    echo "<tr data-cuarto-id='" . htmlspecialchars($fila['cuarto_id']) . "'>";
                    echo "<td>" . htmlspecialchars($fila['cuarto_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['numero_habitacion']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['tipo_habitacion']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['descripcion']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['capacidad']) . "</td>";
                    echo "<td style='style='text-align: center;'>$" . htmlspecialchars($fila['precio_noche']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['estado']) . "</td>";
                    echo "<td>" . htmlspecialchars($fila['fecha_registro']) . "</td>";
                    echo "<td style='display: flex; justify-content: center; align-items: center; height: 60px; gap: 2px;' >";
                    echo "<button class='btnEditar' onclick='editarHabitacion(" . htmlspecialchars($fila['cuarto_id']) . ")'> <i class='fa fa-edit'></i></button>";
                    echo "<button class='btnEliminar' style='width: 60px;' onclick='eliminarHabitacion(" . htmlspecialchars($fila['cuarto_id']) . ")'><i class='fa fa-trash' aria-hidden='true'></i></button>";
                    echo "</td>";
                    echo "</tr>";
                    
                }
                $conexion->close();
            ?>
        </tbody>
    </table>

    <!-- Botón para abrir el modal -->
    <button id="btnNuevaHabitacion">Nueva Habitación</button>

    <!-- Modal para agregar nueva habitación -->
    <div id="modalHabitacion" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Agregar Habitación</h2>
            <form id="formNuevaHabitacion">
                <label for="numeroHabitacion">Numero de Habitación:</label>
                <input type="number" id="numeroHabitacion" name="numero_habitacion" required />
                <label for="tipoHabitacion">Tipo de Habitación:</label>
                <select id="tipoHabitacion" name="tipo_habitacion" required>
                    <option value="individual">Individual</option>
                    <option value="doble">Dos Personas</option>
                    <option value="suite">Suite</option>
                </select>
                <label for="descripcion">Descripcion de la Habitación:</label>
                <input type="text" id="descripcion" name="descripcion" required />
                <label for="capacidad">Capacidad de la Habitación:</label>
                <input type="number" id="capacidad" name="capacidad" required />
                <label for="precioHabitacion">Precio:</label>
                <input type="number" id="precioHabitacion" name="precio_noche" required />
                <label for="estadoHabitacion">Estado:</label>
                <select id="estadoHabitacion" name="estado" required>
                    <option value="disponible">Disponible</option>
                    <option value="ocupado">Ocupado</option>
                    <option value="reservado">Reservada</option>
                    <option value="limpieza">En Limpieza</option>
                    <option value="mantenimiento">Mantenimiento</option>
                </select>
                <label for="fechaRegistro">Fecha de Registro:</label>
                <input type="date" id="fechaRegistro" name="fecha_registro" required />
                <button type="submit">Guardar</button>
            </form>

        </div>
    </div>

    <!-- Modal para editar habitación -->
    <div id="modalEditarHabitacion" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModalEditar()">&times;</span>
            <h2>Editar Habitación</h2>
            <form id="formEditarHabitacion">
                <input type="hidden" id="cuarto_id_editar" name="cuarto_id" />
                <label for="numeroHabitacionEditar">Numero de Habitación:</label>
                <input type="number" id="numeroHabitacionEditar" name="numero_habitacion" required />

                <label for="tipoHabitacionEditar">Tipo de Habitación:</label>
                <select id="tipoHabitacionEditar" name="tipo_habitacion" required>
                    <option value="individual">Individual</option>
                    <option value="doble">Dos Personas</option>
                    <option value="suite">Suite</option>
                </select>

                <label for="descripcionEditar">Descripcion de la Habitación:</label>
                <input type="text" id="descripcionEditar" name="descripcion" required />

                <label for="capacidadEditar">Capacidad de la Habitación:</label>
                <input type="number" id="capacidadEditar" name="capacidad" required />

                <label for="precioHabitacionEditar">Precio:</label>
                <input type="number" id="precioHabitacionEditar" name="precio_noche" required />

                <label for="estadoHabitacionEditar">Estado:</label>
                <select id="estadoHabitacionEditar" name="estado" required>
                    <option value="disponible">Disponible</option>
                    <option value="ocupada">Ocupada</option>
                    <option value="reservado">Reservada</option>
                    <option value="limpieza">En Limpieza</option>
                    <option value="mantenimiento">Mantenimiento</option>
                </select>


                <button type="submit">Guardar cambios</button>
            </form>
        </div>
    </div>

    
</div>

<script src="../js/scripts.js"></script>
<script>
    const modalaggHabitacion = document.getElementById("modalHabitacion");
    const btnAggHabitacion = document.getElementById("btnNuevaHabitacion");
    const span = document.getElementsByClassName("close")[0];

    btnAggHabitacion.onclick = function() {
        modalaggHabitacion.style.display = "block";
    };
    span.onclick = function() {
        modalaggHabitacion.style.display = "none";
    };
    window.onclick = function(event) {
        if (event.target == modalaggHabitacion) {
            modalaggHabitacion.style.display = "none";
        }
    };
</script>
<!-- Incluir SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.getElementById("formNuevaHabitacion").addEventListener("submit", function(event) {
    event.preventDefault(); 

    var numeroHabitacion = document.getElementById("numeroHabitacion").value;
    var tipoHabitacion = document.getElementById("tipoHabitacion").value;
    var descripcion = document.getElementById("descripcion").value;
    var capacidad = document.getElementById("capacidad").value;
    var precioHabitacion = document.getElementById("precioHabitacion").value;
    var estadoHabitacion = document.getElementById("estadoHabitacion").value;
    var fechaRegistro = document.getElementById("fechaRegistro").value;

    var submitButton = document.querySelector("#formNuevaHabitacion button[type='submit']");
    submitButton.disabled = true;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "agregarHabitacion.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.send("numero_habitacion=" + encodeURIComponent(numeroHabitacion) + 
             "&tipo_habitacion=" + encodeURIComponent(tipoHabitacion) + 
             "&descripcion=" + encodeURIComponent(descripcion) +
             "&capacidad=" + encodeURIComponent(capacidad) + 
             "&precio_noche=" + encodeURIComponent(precioHabitacion) +
             "&estado=" + encodeURIComponent(estadoHabitacion) +
             "&fecha_registro=" + encodeURIComponent(fechaRegistro));


    xhr.onload = function() {
        submitButton.disabled = false; 
        if (xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                modalaggHabitacion.style.display = "none";
                
                document.getElementById("formNuevaHabitacion").reset();
                
                var nuevaFila = document.createElement("tr");
                nuevaFila.innerHTML = "<td>" + response.cuarto_id + "</td>" +
                                      "<td>" + response.numero_habitacion + "</td>" + 
                                      "<td>" + tipoHabitacion + "</td>" + 
                                      "<td>" + descripcion + "</td>" +
                                      "<td>" + capacidad + "</td>" +  
                                      "<td>$" + precioHabitacion + "</td>" + 
                                      "<td>" + estadoHabitacion + "</td>" + 
                                      "<td>" + fechaRegistro + "</td>" + 
                                      "<td>" +
                                          "<button class='btnEditar' onclick='editarHabitacion(" + response.cuarto_id + ")'>Editar</button>" +
                                          "<button class='btnEliminar' onclick='eliminarHabitacion(" + response.cuarto_id + ")'>Eliminar</button>" +
                                      "</td>";
                document.querySelector("#tablaCheckInOut tbody").appendChild(nuevaFila);
            } else {
                alert("Error al agregar la habitación.");
            }
        } else {
            alert("Error en la solicitud AJAX.");
        }
    };

    xhr.onerror = function() {
        submitButton.disabled = false; 
        alert("Error de conexión. Por favor, inténtalo de nuevo.");
    };
});

function eliminarHabitacion(cuarto_id) {
    // Usar SweetAlert para la confirmación
    Swal.fire({
        title: "¿Estás seguro de que quieres eliminar esta habitación?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {
        if (result.isConfirmed) {
            // Crear la solicitud AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../admin/eliminarHabitacion.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.send("cuarto_id=" + encodeURIComponent(cuarto_id));

            xhr.onload = function() {
                if (xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Mostrar alerta de éxito
                        Swal.fire({
                            title: "¡Eliminada!",
                            text: "Habitación eliminada con éxito.",
                            icon: "success"
                        });

                        // Eliminar la fila de la tabla
                        var row = document.querySelector("tr[data-cuarto-id='" + cuarto_id + "']");
                        if (row) {
                            row.remove();
                        }
                    } else {
                        // Mostrar alerta de error
                        Swal.fire({
                            title: "Error",
                            text: "Error al eliminar la habitación.",
                            icon: "error"
                        });
                    }
                } else {
                    // Mostrar alerta de error en caso de fallo en la solicitud
                    Swal.fire({
                        title: "Error",
                        text: "Error en la solicitud AJAX.",
                        icon: "error"
                    });
                }
            };

            xhr.onerror = function() {
                // Mostrar alerta de error de conexión
                Swal.fire({
                    title: "Error",
                    text: "Error de conexión. Por favor, inténtalo de nuevo.",
                    icon: "error"
                });
            };
        }
    });
}


function editarHabitacion(cuarto_id) {
    console.log("Editar habitación ID:", cuarto_id);
    // Realizar la solicitud AJAX para obtener los datos de la habitación
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "../admin/editarHabitacion.php?cuarto_id=" + encodeURIComponent(cuarto_id), true);
    xhr.onload = function() {
        if (xhr.status == 200) {
            console.log(xhr.responseText);  // Agrega esto para ver la respuesta completa
            try {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    document.getElementById("cuarto_id_editar").value = response.data.cuarto_id;
                    document.getElementById("numeroHabitacionEditar").value = response.data.numero_habitacion;
                    document.getElementById("tipoHabitacionEditar").value = response.data.tipo_habitacion;
                    document.getElementById("descripcionEditar").value = response.data.descripcion;
                    document.getElementById("capacidadEditar").value = response.data.capacidad;
                    document.getElementById("precioHabitacionEditar").value = response.data.precio_noche;
                    document.getElementById("estadoHabitacionEditar").value = response.data.estado;
                    document.getElementById("modalEditarHabitacion").style.display = "block";
                } else {
                    alert("Error al obtener los datos de la habitación.");
                }
            } catch (e) {
                alert("Error al analizar la respuesta JSON: " + e.message);
            }
        } else {
            alert("Error en la solicitud GET. Código de estado: " + xhr.status);
        }
    };
    xhr.send();
}

// Cerrar el modal de edición
function cerrarModalEditar() {
    document.getElementById("modalEditarHabitacion").style.display = "none";
}

document.getElementById("formEditarHabitacion").addEventListener("submit", function(event) {
    event.preventDefault(); // Evitar que el formulario se envíe de forma tradicional

    // Obtener los valores del formulario
    var cuarto_id = document.getElementById("cuarto_id_editar").value;
    var numeroHabitacion = document.getElementById("numeroHabitacionEditar").value;
    var tipoHabitacion = document.getElementById("tipoHabitacionEditar").value;
    var descripcion = document.getElementById("descripcionEditar").value;
    var capacidad = document.getElementById("capacidadEditar").value;
    var precioHabitacion = document.getElementById("precioHabitacionEditar").value;
    var estadoHabitacion = document.getElementById("estadoHabitacionEditar").value;

    // Realizar la solicitud AJAX para actualizar la habitación
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../admin/actualizarHabitacion.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Enviar los datos del formulario
    xhr.send("cuarto_id=" + encodeURIComponent(cuarto_id) + 
             "&numero_habitacion=" + encodeURIComponent(numeroHabitacion) + 
             "&tipo_habitacion=" + encodeURIComponent(tipoHabitacion) + 
             "&descripcion=" + encodeURIComponent(descripcion) + 
             "&capacidad=" + encodeURIComponent(capacidad) + 
             "&precio_noche=" + encodeURIComponent(precioHabitacion) + 
             "&estado=" + encodeURIComponent(estadoHabitacion) + 
             "&fecha_registro=" + encodeURIComponent(fechaRegistro));

    // Manejar la respuesta del servidor
    xhr.onload = function() {
        if (xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
                alert("Habitación actualizada con éxito.");

                // Cerrar el modal
                cerrarModalEditar();

                // Actualizar la fila de la tabla con los nuevos datos
                var row = document.querySelector("tr[data-cuarto-id='" + cuarto_id + "']");
                if (row) {
                    row.children[1].textContent = numeroHabitacion;
                    row.children[2].textContent = tipoHabitacion;
                    row.children[3].textContent = descripcion;
                    row.children[4].textContent = capacidad;
                    row.children[5].textContent = "$" + precioHabitacion;
                    row.children[6].textContent = estadoHabitacion;
                    row.children[7].textContent = fechaRegistro;
                }
            } else {
                alert("Error al actualizar la habitación.");
            }
        } else {
            alert("Error en la solicitud AJAX.");
        }
    };
});

</script>
<?php include "../admin/includes/footer.php"; ?>
</html>
