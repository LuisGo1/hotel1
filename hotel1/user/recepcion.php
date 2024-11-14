<?php
include "../user/includes/header.php";
?>

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
