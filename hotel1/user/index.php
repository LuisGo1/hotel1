<?php
include "../user/includes/header.php";
?>
    <!-- Contenido Principal -->
    <div class="main-content">
        <h1>Bienvenido al Panel de usuario.</h1>
        <p>Seleccione una opción del menú lateral para gestionar las habitaciones del hotel.</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
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
</body>
</html>
