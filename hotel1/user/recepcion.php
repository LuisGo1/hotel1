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
        <h2>Asignar Cliente a Habitación <span id="numeroHabitacion"></span></h2>


        <div class="input-container">
            <label for="buscador">Buscar Cliente:</label>
            <input type="text" id="buscador" placeholder="Buscar por nombre o apellido" onkeyup="filtrarClientes()">

            <div id="dropdownResultados" class="dropdown">
                <ul id="listaClientes">
                </ul>
            </div>
        </div>
        <form id="asignarClienteForm">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" required>

            <label for="cantidadP">Cantidad de personas:</label>
            <input type="number" id="cantidadP" name="cantidadP" required>

            <button type="submit">Asignar Cliente</button>
        </form>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dropdownToggle = document.querySelector(".dropdown-toggle");
        const dropdown = document.querySelector(".dropdown");

        dropdownToggle.addEventListener("click", function(e) {
            e.preventDefault();
            dropdown.classList.toggle("active");
        });
    });
</script>
<script>
    const modal = document.getElementById("modalAsignarCliente");
    const closeModal = document.getElementsByClassName("close")[0];
    const habitacionesDisponibles = document.querySelectorAll(".room-card.available");

    habitacionesDisponibles.forEach(habitacion => {
        habitacion.addEventListener("click", function() {
            modal.style.display = "block";
        });
    });

    closeModal.onclick = function() {
        modal.style.display = "none";
    };

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
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
        console.log(`Nivel seleccionado: ${nivelId}`);

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

                        container.appendChild(roomContainer);
                    });
                } else {
                    container.innerHTML = `<p>Error al obtener las habitaciones: ${data.message}</p>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Detectar clic en cualquier room-container y abrir modal
    document.addEventListener("click", function(event) {
        const roomContainer = event.target.closest(".room-container");
        if (roomContainer) {
            const numeroHabitacion = roomContainer.getAttribute("data-numero");
            console.log(`Número de habitación: ${numeroHabitacion}`);

            const modal = document.getElementById('modalAsignarCliente');
            modal.style.display = 'block';

            document.getElementById('numeroHabitacion').textContent = numeroHabitacion;
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
        const busqueda = document.getElementById("buscador").value.toLowerCase();
        const listaClientes = document.getElementById("listaClientes");
        const dropdownResultados = document.getElementById("dropdownResultados");

        listaClientes.innerHTML = "";

        if (!busqueda) {
            dropdownResultados.style.display = "none";
            return;
        }

        const url = `../user/consultas/buscador_cliente.php?busqueda=${encodeURIComponent(busqueda)}`;

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                console.log("Raw response:", response); 
                return response.json();
            })
            .then(clientes => {
                console.log("Datos devueltos por el servidor:", clientes); 

                if (clientes.clientes.length > 0) {
                    dropdownResultados.style.display = "block";

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
                            dropdownResultados.style.display = "none";
                        };
                        listaClientes.appendChild(clienteItem);
                    });
                } else {
                    const noResultItem = document.createElement("li");
                    noResultItem.textContent = "No se encontraron clientes.";
                    listaClientes.appendChild(noResultItem);
                }

            })
            .catch(error => {
                console.error("Error al obtener los clientes:", error);
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
</script>


</body>

</html>