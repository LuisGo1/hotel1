<?php
session_start();
include "../user/includes/header.php";
?>

<!-- Formulario de apertura de caja -->
<div class="apertura-caja-container">
    <h2>Apertura de caja</h2>
    <form id="aperturaForm">
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" required>
        </div>
        <div class="form-group">
            <label for="monto">Monto Inicial</label>
            <input type="number" id="monto" name="monto" placeholder="0.00" required step="0.01">
        </div>
        <button id="submit-btn" class="submit-btn" type="submit" disabled>Abrir Caja</button>
        <input type="hidden" id="empleado_id" name="empleado_id" value="<?php echo $_SESSION['empleado_id']; ?>">
    </form>
</div>

<!-- Script que maneja el formulario con AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Habilita el botón solo si el monto es mayor a 0
const montoInput = document.getElementById("monto");
const abrirBtn = document.getElementById("submit-btn");

montoInput.addEventListener("input", function() {
    abrirBtn.disabled = montoInput.value <= 0;
});

// Manejo de la solicitud AJAX
document.getElementById("aperturaForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita el envío normal del formulario

    const formData = {
        fecha: document.getElementById("fecha").value,
        monto: document.getElementById("monto").value,
        empleado_id: document.getElementById("empleado_id").value
    };

    // Enviar datos con AJAX
    $.ajax({
        url: "apertura_backend.php", // Ruta al archivo PHP del backend
        type: "POST",
        data: formData,
        success: function(response) {
            try {
                // Asegúrate de que la respuesta sea válida JSON
                const data = JSON.parse(response);

                if (data.success) {
                    Swal.fire({
                        title: 'Éxito',
                        text: data.message,
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload(); // Recargar página si es necesario
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: data.error,
                        icon: 'error'
                    });
                }
            } catch (error) {
                // Si la respuesta no es JSON válido
                Swal.fire({
                    title: 'Error',
                    text: 'La respuesta no es válida. Por favor, intenta de nuevo.',
                    icon: 'error'
                });
            }
        },
        error: function() {
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un error inesperado. Por favor, intenta más tarde.',
                icon: 'error'
            });
        }
    });
});
</script>
