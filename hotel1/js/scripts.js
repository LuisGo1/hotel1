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

// scripts.js
document.getElementById("formNuevaHabitacion").addEventListener("submit", function(event) {
    event.preventDefault();

    const tipoHabitacion = document.getElementById("tipoHabitacion").value;
    const precioHabitacion = document.getElementById("precioHabitacion").value;
    const estadoHabitacion = document.getElementById("estadoHabitacion").value;

    fetch("habitaciones.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `tipo_habitacion=${encodeURIComponent(tipoHabitacion)}&precio_noche=${encodeURIComponent(precioHabitacion)}&estado=${encodeURIComponent(estadoHabitacion)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const tbody = document.querySelector("#tablaCheckInOut tbody");
            const newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td>${data.numero_habitacion}</td>
                <td>${tipoHabitacion}</td>
                <td>$${precioHabitacion}</td>
                <td>${estadoHabitacion}</td>
                <td>
                    <button class='btnEditar' onclick='editarHabitacion(${data.cuarto_id})'>Editar</button>
                    <button class='btnEliminar' onclick='eliminarHabitacion(${data.cuarto_id})'>Eliminar</button>
                </td>
            `;
            tbody.appendChild(newRow);
            document.getElementById("formNuevaHabitacion").reset();
            modalaggHabitacion.style.display = "none";
        } else {
            alert("Error al guardar la habitación");
        }
    })
    .catch(error => console.error("Error:", error));
});
