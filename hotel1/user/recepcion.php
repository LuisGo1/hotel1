<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitaciones</title>

    <!-- Estilos de DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">

    <!-- Tu archivo de CSS -->
    <link rel="stylesheet" href="../../hotel1/css/userstyle.css">
</head>
<style>
    /* Estilo para el dropdown */
.dropdown {
    position: relative;
}

/* Estilo para el menú desplegable con animación */
.dropdown-menu {
    display: none;
    position: absolute;
    left: 100%;
    top: 0;
    background-color: #444;
    min-width: 160px;
    padding: 10px 0;
    border-radius: 4px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);

    /* Animación */
    opacity: 1;
    transform: translateY(-10px); /* Inicia un poco desplazado hacia arriba */
    transition: opacity 0.3s ease, transform 0.3s ease;
}

/* Mostrar el dropdown con animación cuando se hace hover */
.dropdown:hover .dropdown-menu {
    display: block;
    opacity: 1;
    transform: translateY(0); /* Desliza hacia su posición final */
}

/* Estilo general del modal */
.modal {
  display: none; /* Oculto por defecto */
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.4); /* Fondo oscuro con opacidad */
}

/* Contenido del modal */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  max-width: 500px;
  border-radius: 8px;
}

/* Botón de cerrar */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.close:hover, .close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}

/* Estilo de los labels y campos del formulario */
.modal-content label {
  display: block;
  margin-top: 10px;
  font-weight: bold;
}

.modal-content input[type="text"],
.modal-content input[type="tel"],
.modal-content input[type="email"],
.modal-content input[type="date"],
.modal-content input[type="number"],
.modal-content textarea {
  width: 100%;
  padding: 8px;
  margin-top: 5px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.modal-content button {
  background-color: #4CAF50;
  color: white;
  padding: 10px 15px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.modal-content button:hover {
  background-color: #45a049;
}

</style>
<body>

    <div class="sidebar">
        <h2>Hotel Admin Dashboard</h2>
        <ul>
            <li><a href="../user/">Dashboard</a></li>
            <li><a href="../user/recepcion.php">Recepción</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">Caja</a>
                <ul class="dropdown-menu">
                    <li><a href="../user/caja_apertura.php">Apertura de caja</a></li>
                    <li><a href="../user/cierre-caja.php">Cierre de caja</a></li>
                </ul>
            </li>
        </ul>
    </div>

</div>

    <section class="levels">
        <div class="level-card">Nivel 1</div>
        <div class="level-card">Nivel 2</div>
        <div class="level-card">Nivel 3</div>
        <div class="level-card">Nivel 4</div>
    </section>

    <div class="room-container">
        <!-- Cuadros de habitaciones -->
        <div class="room-card cleaning">
            <div class="room-number">Habitación 101</div>
            <div class="room-type">Simple</div>
            <div class="room-status">Limpieza</div>
        </div>

        <div class="room-card occupied">
            <div class="room-number">Habitación 102</div>
            <div class="room-type">Matrimonial</div>
            <div class="room-status">Ocupado</div>
        </div>

        <div class="room-card available">
            <div class="room-number">Habitación 103</div>
            <div class="room-type">Familiar</div>
            <div class="room-status">Disponible</div>
        </div>

        <div class="room-card available">
            <div class="room-number">Habitación 104</div>
            <div class="room-type">Doble</div>
            <div class="room-status">Disponible</div>
        </div>

        <div class="room-card occupied">
            <div class="room-number">Habitación 105</div>
            <div class="room-type">Simple</div>
            <div class="room-status">Ocupado</div>
        </div>

        <div class="room-card maintenance">
            <div class="room-number">Habitación 106</div>
            <div class="room-type">Simple</div>
            <div class="room-status">Mantenimiento</div>
        </div>
    </div>

    <section class="status">
        <div class="level-card">Disponible
            <span>2</span>
        </div>
        <div class="level-card">Ocupado
            <span>1</span>
        </div>
        <div class="level-card">Limpieza
            <span>1</span>
        </div>
        <div class="level-card">Mantenimiento
            <span>5</span>
        </div>
    </section>

    <!-- Modal para Asignar Cliente -->
<div id="modalAsignarCliente" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Asignar Cliente a Habitación</h2>
    
    <!-- Formulario para Asignar Cliente -->
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
        // Controla el desplegable del menú "Caja"
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
        // Referencias al modal y a las habitaciones disponibles
const modal = document.getElementById("modalAsignarCliente");
const closeModal = document.getElementsByClassName("close")[0];
const habitacionesDisponibles = document.querySelectorAll(".room-card.available");

// Mostrar el modal al hacer clic en una habitación disponible
habitacionesDisponibles.forEach(habitacion => {
  habitacion.addEventListener("click", function () {
    modal.style.display = "block";
  });
});

// Cerrar el modal al hacer clic en la "X"
closeModal.onclick = function () {
  modal.style.display = "none";
};

// Cerrar el modal al hacer clic fuera del contenido
window.onclick = function (event) {
  if (event.target === modal) {
    modal.style.display = "none";
  }
};
    </script>

</body>
</html>
