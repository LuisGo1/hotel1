$(document).ready(function() {
    // Inicializar DataTable


    // Modal: Abrir y Cerrar
    var modal = document.getElementById("modalCheckInOut");
    var btn = document.getElementById("btnNuevoCheckInOut");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Acción de agregar nuevo registro
    $("#formNuevoCheckInOut").submit(function(event) {
        event.preventDefault();
        // Aquí va el código para guardar el nuevo registro (puede ser una llamada AJAX)
        alert("Nuevo registro agregado");
        modal.style.display = "none"; // Cerrar modal
    });

    // Función para editar registro
    window.editarRegistro = function(id) {
        alert("Editar registro con ID: " + id);
    }

    // Función para eliminar registro
    window.eliminarRegistro = function(id) {
        if (confirm("¿Seguro que quieres eliminar este registro?")) {
            alert("Registro con ID: " + id + " eliminado");
        }
    }
});
