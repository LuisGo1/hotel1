<?php
include "../user/includes/header.php";
include "../conecction/db.php"
?>



<?php
$sql = "SELECT nivel_id, nombre_nivel FROM niveles_habitaciones";
$resultado = $conexion->query($sql);

// Verifica si hay resultados
if ($resultado->num_rows > 0): ?>
    <section class="levels">
        <?php
        while ($nivel = $resultado->fetch_assoc()): ?>
            <div class="level-card" data-id="<?php echo $nivel['nivel_id']; ?>" onclick="confirmclic(<?php echo $nivel['nivel_id']; ?>)">
                <?php echo htmlspecialchars($nivel['nombre_nivel']); ?>
            </div>


        <?php endwhile; ?>
    </section>
<?php else: ?>
    <p>No hay niveles disponibles.</p>
<?php endif;

$conexion->close();
?>
<div class="rooms">
    <div class="room-container">
        <!-- Cuadros de habitaciones -->
    </div>

</div>

<?php
include("../conecction/db.php");
$sql = "SELECT 
    COUNT(CASE WHEN estado = 'disponible' THEN 1 END) AS disponibles,
    COUNT(CASE WHEN estado = 'ocupado' THEN 1 END) AS ocupadas,
    COUNT(CASE WHEN estado = 'limpieza' THEN 1 END) AS en_limpieza,
    COUNT(CASE WHEN estado = 'mantenimiento' THEN 1 END) AS en_mantenimiento,
    COUNT(CASE WHEN estado = 'reservado' THEN 1 END) AS reservado
    FROM habitaciones;";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0): ?>
    <section class="info">
        <?php
        $estado = $resultado->fetch_assoc(); ?>

        <!-- Mostrar las tarjetas con los conteos -->
        <div class="categories-card">
            <h3>Habitaciones Disponibles</h3>
            <h1><?php echo $estado['disponibles']; ?></h1>
        </div>

        <div class="categories-card">
            <h3>Habitaciones Ocupadas</h3>
            <h1><?php echo $estado['ocupadas']; ?></h1>
        </div>

        <div class="categories-card">
            <h3>Habitaciones en Limpieza</h3>
            <h1><?php echo $estado['en_limpieza']; ?></h1>
        </div>

        <div class="categories-card">
            <h3>Habitaciones en Mantenimiento</h3>
            <h1><?php echo $estado['en_mantenimiento']; ?></h1>
        </div>

        <div class="categories-card">
            <h3>Habitaciones Reservadas</h3>
            <h1><?php echo $estado['reservado']; ?></h1>
        </div>

    </section>
<?php else: ?>
    <p>No hay datos disponibles.</p>
<?php endif;
$conexion->close();
?>

<!-- Modal para Asignar Cliente -->
<div id="modalAsignarCliente" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Asignar Cliente a Habitación <span id="numeroHabitacion"></span><span id="id_habitacion"></span></h2>
        <div class="swipe-padre">
            <div class="swipe-container" id="swipeContainer">
                <button class="swipe-button registro" id="">Registro</button>
                <button class="swipe-button reservaciones" id="swipeButtonReservacion">Reservaciones</button>

            </div>
        </div>

        <div class="input-container">
            <label for="buscador">Buscar Cliente:</label>
            <input type="text" id="buscador" placeholder="Buscar por nombre o apellido" onkeyup="filtrarClientes()">
            <div id="dropdownResultados" class="dropdown">
                <ul id="listaClientes"></ul>
            </div>


        </div>
        <form id="asignarClienteForm">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>

            <label for="telefono">Teléfono:</label>
            <input type="number" id="telefono" name="telefono" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" required>

            <label for="cantidadP">Cantidad de personas:</label>
            <input type="number" id="cantidadP" name="cantidadP" required>

            <button type="submit" id="submit">Asignar Cliente</button>
        </form>
    </div>
</div>

<!-- Modal Para Reservaciones -->
<div id="modalReservaciones" class="modal">
    <div class="modal-content">
        <span class="close" id="closeReservaciones">&times;</span>
        <h2>Reservar Habitación <span id="numeroHabitacion1"></span></h2>
        <div class="swipe-padre">
            <div class="swipe-container" id="swipeContainer">
                <button class="swipe-button registro" id="swipeButtonRegistro">Registro</button>
                <button class="swipe-button reservaciones" id="">Reservaciones</button>

            </div>
        </div>
        <div class="input-container">
            <label for="buscador">Buscar Cliente:</label>
            <input type="text" id="buscadorReserva" placeholder="Buscar por nombre o apellido" onkeyup="filtrarClientes()">
            <div id="dropdownResultadosReserva" class="dropdown">
                <ul id="listaClientesReserva"></ul>
            </div>


        </div>
        <form id="asignarClienteReservaForm">
            <label for="nombrereserva">Nombre:</label>
            <input type="text" id="nombrereserva" name="nombre">

            <label for="apellidoreserva">Apellido:</label>
            <input type="text" id="apellidoreserva" name="apellido">

            <label for="telefonoreserca">Telefono:</label>
            <input type="number" id="telefonoreserca" name="telefono">

            <label for="emailreserva">Email:</label>
            <input type="email" id="emailreserva" name="email">

            <label for="direccionreserva">Dirección:</label>
            <input type="text" id="direccionreserva" name="direccion">

            <label for="cantidadPreserva">Cantidad de personas:</label>
            <input type="number" id="cantidadPreserva" name="cantidadP">
            <label for="fechaingresoreserva">Fecha de Ingreso:</label>
            <input type="date" id="fechaingresoreserva" name="fechaingresoreserva" required />

            <button type="submit" id="submitreservacion">Reservar</button>
        </form>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    const modal = document.getElementById("modalAsignarCliente");
    const modalreservacion = document.getElementById("modalReservaciones");
    const closeModal = document.getElementsByClassName("close")[0];
    const closeReservaciones = document.getElementById("closeReservaciones");
    const habitacionesDisponibles = document.querySelectorAll(".room-card.available");
    const modalreservaciones = document.getElementById('modalReservaciones');
    const buttonReservaciones = document.getElementById('swipeButtonReservacion');
    const buttonRegistro = document.getElementById("swipeButtonRegistro");


    closeModal.onclick = function() {
        modal.style.display = "none";
    };

    closeReservaciones.onclick = function() {
        modalreservaciones.style.display = "none";
    };


    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        } else if (event.target === modalreservaciones) {
            modalreservaciones.style.display = "none";
        }
    };

    buttonRegistro.onclick = function() {
        modal.style.display = "block";
        modalreservaciones.style.display = "none";

    };
    buttonReservaciones.onclick = function() {
        modalreservaciones.style.display = "block";
        modal.style.display = "none";

    };




    document.addEventListener('DOMContentLoaded', function() {
        const primerNivel = document.querySelector('.level-card');
        if (primerNivel) {
            const nivelId = primerNivel.getAttribute('data-id');
            confirmclic(nivelId);
            primerNivel.classList.add('selected');
        }
    });

    function confirmclic(nivelId) {

        const niveles = document.querySelectorAll('.level-card');
        niveles.forEach(nivel => {
            nivel.classList.remove('selected');
        });

        const nivelSeleccionado = document.querySelector(`[data-id='${nivelId}']`);
        nivelSeleccionado.classList.add('selected');

        fetch('../user/consultas/obtener_habitaciones.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'nivel_id=' + nivelId
            }).then(response => response.json())
            .then(data => {
                const container = document.querySelector('.rooms');
                container.innerHTML = '';

                if (data.success) {
                    data.habitaciones.forEach(habitacion => {
                        const roomContainer = document.createElement('div');
                        roomContainer.classList.add('room-container', getEstadoClass(habitacion.estado));
                        roomContainer.setAttribute('data-numero', habitacion.numero_habitacion); // Atributo con el número
                        roomContainer.setAttribute('data_idcuarto', habitacion.cuarto_id);
                        roomContainer.setAttribute('data-estado', habitacion.estado);

                        roomContainer.innerHTML = `
                            <div class="room-card-face front">
                                <h2 class="numero">N°: ${habitacion.numero_habitacion}</h2>
                                <h3 class="tipo">${habitacion.tipo_habitacion}</h3>
                                <p class="estado"> <span class="${getEstadoClass(habitacion.estado)}">${habitacion.estado}</span></p>
                                <h3 class="precio">Precio: $${habitacion.precio_noche}</h3>
                            </div>
                            <div class="room-card-face back">
                                <h2 class="descripcion">Descripción:</h2>
                                <p class="descripcionbase">${habitacion.descripcion}</p>
                                <h3 class="capacidad">Capacidad: ${habitacion.capacidad}</h3>
                            </div>
                        `;

                        roomContainer.addEventListener('click', () => gestionarHabitacion(roomContainer));

                        container.appendChild(roomContainer);
                    });
                } else {
                    container.innerHTML = `<p>Error al obtener las habitaciones: ${data.message}</p>`;
                }
            })
            .catch(error => {});
    }
    let id_habitacion = null;
    // Detectar clic en cualquier room-container y abrir modal
    document.addEventListener("click", function(event) {
        const roomContainer = event.target.closest(".room-container");

        if (roomContainer) {
            const estado = roomContainer.getAttribute("data-estado"); // Obtener el estado de la habitación
            const numeroHabitacion = roomContainer.getAttribute("data-numero");
            id_habitacion = roomContainer.getAttribute("data_idcuarto");

            // Verificar si la habitación está en mantenimiento
            if (estado === "mantenimiento") {
                Swal.fire({
                    title: "Habitación en mantenimiento",
                    text: "Esta habitación no está disponible en estos momento. Por Favor comuniquese con Administración.",
                    icon: "warning",
                    confirmButtonText: "Aceptar"
                });
                return; // Salir de la función para evitar que se abra el modal
            }

            // Abrir modal solo si la habitación NO está en mantenimiento
            const modal = document.getElementById('modalAsignarCliente');
            modal.style.display = 'block';

            document.getElementById('numeroHabitacion').textContent = numeroHabitacion;
            document.getElementById('numeroHabitacion1').textContent = numeroHabitacion;
        }
    });




    function getEstadoClass(estado) {
        switch (estado) {
            case 'disponible':
                return 'disponible';
            case 'reservado':
                return 'reservado';
            case 'ocupado':
                return 'ocupado';
            case 'limpieza':
                return 'limpieza';
            case 'mantenimiento':
                return 'mantenimiento';
            default:
                return 'default';
        }
    }

    function filtrarClientes() {
        const busquedaAsignar = document.getElementById("buscador").value.toLowerCase();
        const busquedaReserva = document.getElementById("buscadorReserva") ? document.getElementById("buscadorReserva").value.toLowerCase() : '';

        const listaClientesAsignar = document.getElementById("listaClientes");
        const dropdownResultadosAsignar = document.getElementById("dropdownResultados");
        const listaClientesReserva = document.getElementById("listaClientesReserva");
        const dropdownResultadosReserva = document.getElementById("dropdownResultadosReserva");

        // Limpiar las listas de resultados anteriores
        listaClientesAsignar.innerHTML = "";
        listaClientesReserva.innerHTML = "";

        // Si no hay búsqueda, ocultamos los dropdowns
        if (!busquedaAsignar && !busquedaReserva) {
            dropdownResultadosAsignar.style.display = "none";
            dropdownResultadosReserva.style.display = "none";
            return;
        }

        // Seleccionar la URL de búsqueda
        const url = `../user/consultas/buscador_cliente.php?busqueda=${encodeURIComponent(busquedaAsignar || busquedaReserva)}`;

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(clientes => {
                if (clientes.clientes.length > 0) {
                    // Mostrar dropdown correspondiente según el modal activo
                    if (busquedaAsignar) {
                        dropdownResultadosAsignar.style.display = "block";
                    }
                    if (busquedaReserva) {
                        dropdownResultadosReserva.style.display = "block";
                    }

                    // Mostrar resultados en el modal asignar cliente
                    if (busquedaAsignar) {
                        clientes.clientes.forEach(cliente => {
                            const clienteItem = document.createElement("li");
                            clienteItem.textContent = `${cliente.nombre_cliente} ${cliente.apellido_cliente}`;
                            clienteItem.onclick = function() {
                                document.getElementById("nombre").value = cliente.nombre_cliente;
                                document.getElementById("apellido").value = cliente.apellido_cliente;
                                document.getElementById("telefono").value = cliente.telefono;
                                document.getElementById("email").value = cliente.email;
                                document.getElementById("direccion").value = cliente.direccion;
                                document.getElementById("buscador").value = "";
                                dropdownResultadosAsignar.style.display = "none";
                            };
                            listaClientesAsignar.appendChild(clienteItem);
                        });
                    }

                    // Mostrar resultados en el modal reservaciones
                    if (busquedaReserva) {
                        clientes.clientes.forEach(cliente => {
                            const clienteItem = document.createElement("li");
                            clienteItem.textContent = `${cliente.nombre_cliente} ${cliente.apellido_cliente}`;
                            clienteItem.onclick = function() {
                                document.getElementById("nombrereserva").value = cliente.nombre_cliente;
                                document.getElementById("apellidoreserva").value = cliente.apellido_cliente;
                                document.getElementById("telefonoreserca").value = cliente.telefono;
                                document.getElementById("emailreserva").value = cliente.email;
                                document.getElementById("direccionreserva").value = cliente.direccion;
                                document.getElementById("buscadorReserva").value = "";
                                dropdownResultadosReserva.style.display = "none";
                            };
                            listaClientesReserva.appendChild(clienteItem);
                        });
                    }
                } else {
                    const noResultItem = document.createElement("li");
                    noResultItem.textContent = "No se encontraron clientes.";
                    if (busquedaAsignar) {
                        listaClientesAsignar.appendChild(noResultItem);
                    }
                    if (busquedaReserva) {
                        listaClientesReserva.appendChild(noResultItem);
                    }
                }
            })
            .catch(error => {
                console.error("Error al buscar clientes:", error);
                dropdownResultadosAsignar.style.display = "none";
                dropdownResultadosReserva.style.display = "none";
            });
    }


    // Detectar clic fuera del dropdown para cerrarlo
    document.addEventListener("click", function(event) {
        const buscador = document.getElementById("buscador");
        const dropdownResultados = document.getElementById("dropdownResultados");

        if (!buscador.contains(event.target) && !dropdownResultados.contains(event.target)) {
            dropdownResultados.style.display = "none";
        }
    });

    // ENVIAR REGISTRO
    var empleadoId = <?php echo $_SESSION['empleado_id']; ?>;
    $('#submit').click(function(e) {
        e.preventDefault(); // Evita el comportamiento por defecto del formulario
        console.log("id_empleado", empleadoId);
        console.log("id_habitacion", id_habitacion);
        // Recoger los datos del formulario

        var nombre = $('#nombre').val().trim();
        var apellidos = $('#apellido').val().trim();
        var correo = $('#email').val().trim();
        var telefono = $('#telefono').val().trim();
        var direccion = $('#direccion').val().trim();
        var cantidad = $('#cantidadP').val().trim();

        // Verificamos si algún campo obligatorio está vacío
        if (nombre === '' || apellidos === '' || correo === '' || telefono === '' || direccion === '' || cantidad === '') {
            Swal.fire({
                title: 'Error',
                text: 'Todos los campos son obligatorios',
                icon: 'error'
            });
            return;
        }


        $.ajax({
            type: 'POST',
            url: '../user/consultas/insercioncheck.php',
            data: {
                id: empleadoId,
                id_cuarto: id_habitacion,
                nombre: nombre,
                apellidos: apellidos,
                correo: correo,
                telefono: telefono,
                direccion: direccion,
                cantidad: cantidad,



            },

            success: function(data) {
                console.log("respuest", data);
                const response = JSON.parse(data);
                if (response.success) {
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Datos Guardados correctamente',
                        timer: 1500,
                        showConfirmButton: false,
                        icon: 'success'
                    }).then(function() {
                        window.location.reload();
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
                console.log('Error al actualizar los datos:', xhr.responseText);
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al actualizar los datos.',
                    icon: 'error'
                });
            }
        });
    });

    var empleadoId = <?php echo $_SESSION['empleado_id']; ?>;
    $('#submitreservacion').click(function(e) {
        e.preventDefault(); // Evita el comportamiento por defecto del formulario
        console.log("id_empleado", empleadoId);
        console.log("id_habitacion", id_habitacion);
        // Recoger los datos del formulario

        var nombre = $('#nombrereserva').val().trim();
        var apellidos = $('#apellidoreserva').val().trim();
        var telefono = $('#telefonoreserca').val().trim();
        var correo = $('#emailreserva').val().trim();
        var direccion = $('#direccionreserva').val().trim();
        var cantidad = $('#cantidadPreserva').val().trim();
        var fecha = $('#fechaingresoreserva').val().trim();


        // Verificamos si algún campo obligatorio está vacío
        if (nombre === '' || apellidos === '' || correo === '' || telefono === '' || direccion === '' || cantidad === '' || fecha === '') {
            Swal.fire({
                title: 'Error',
                text: 'Todos los campos son obligatorios',
                icon: 'error'
            });
            return;
        }

        $.ajax({
            type: 'POST',
            url: '../user/consultas/insercionreservas.php',
            data: {
                id: empleadoId,
                id_cuarto: id_habitacion,
                nombre: nombre,
                apellidos: apellidos,
                correo: correo,
                telefono: telefono,
                direccion: direccion,
                cantidad: cantidad,
                fecha: fecha,

            },

            success: function(data) {
                console.log("respuest", data);
                const response = JSON.parse(data);
                if (response.success) {
                    Swal.fire({
                        title: 'Éxito',
                        text: 'Datos Guardados correctamente',
                        timer: 1500,
                        showConfirmButton: false,
                        icon: 'success'
                    }).then(function() {
                        window.location.reload();
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
                console.log('Error al actualizar los datos:', xhr.responseText);
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un problema al actualizar los datos.',
                    icon: 'error'
                });
            }
        });
    });
</script>


</body>

</html>