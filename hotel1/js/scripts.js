const sidebar = document.querySelector(".sidebar");
const bars = document.getElementById("menu-toggle");
const body = document.querySelector("body");

// Alterna la clase "active" para abrir y cerrar el sidebar cuando se hace clic en el ícono de barras
bars.addEventListener("click", function (event) {
    sidebar.classList.toggle("active");
    event.stopPropagation(); // Evita que el clic en el ícono active el clic en el body
});

// Detecta clics en cualquier parte del body (fuera del sidebar)
body.addEventListener("click", function (event) {
    // Verifica que el clic no sea dentro del sidebar ni en el ícono de barras
    if (sidebar.classList.contains("active") && !sidebar.contains(event.target) && !bars.contains(event.target)) {
        sidebar.classList.remove("active"); // Cierra el sidebar
    }
});


const modal = document.getElementById("modalReserva");
const btnNuevaReserva = document.getElementById("btnNuevaReserva");
const spanClose = document.querySelector(".close");

// Mostrar el modal al hacer clic en "Nueva Reserva"
btnNuevaReserva.onclick = function () {
    modal.style.display = "block";
};

// Cerrar el modal al hacer clic en la "X"
spanClose.onclick = function () {
    modal.style.display = "none";
};

// Cerrar el modal al hacer clic fuera de la ventana modal
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
};


