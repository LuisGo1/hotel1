<?php
include "../admin/includes/header.php";
?>

<div class="main-content">
    <h1>Empleados</h1>

    <table id="tablaCheckInOut" class="display">
        <thead>
            <tr>

                <th>NOMBRE</th>
                <th>APELLIDO</th>
                <th>EMAIL</th>
                <th>TELEFONO</th>
                <th>ROL</th>
                <th>INGRESO</th>
                <th>ESTADO</th>
                <th></th>

            </tr>
        </thead>

        <tbody>
            <?php
            include("../conecction/db.php");
            $result = mysqli_query($conexion, " SELECT *, DATE(fecha_ingreso) as fecha, estado FROM empleados;
");
            while ($fila = mysqli_fetch_assoc($result)) :
            ?>
            <tr>
                <td><?php echo $fila['nombre_empleado']; ?></td>
                <td><?php echo $fila['apellido_empleado']; ?></td>
                <td><?php echo $fila['email']; ?></td>
                <td><?php echo $fila['telefono']; ?></td>
                <td><?php echo $fila['rol']; ?></td>
                <td><?php echo $fila['fecha']; ?></td>
                <td><?php echo $fila['estado']; ?></td>
                <td>
                    <button class="btnEditar" onclick="editarHabitacion(102)"><i class="fa fa-edit"></i></button>
                    <button class="btnEliminar" style="width:80px ;" onclick="eliminarHabitacion(102)"><i
                            class="fa fa-trash"></i></button>
                </td>

                <!-- 
                    <td>
                        <button type="button" class="btn btn-warning m-1" data-bs-toggle="modal" data-bs-target="#editar<?php echo $fila['empleado_id']; ?>">
                            <i class="fa fa-edit"></i>
                        </button>

                        <button type="button" class="btn btn-danger m-1" onclick="confirmDelete(<?php echo $fila['empleado_id']; ?>, '<?php echo $fila['nombre_empleado']; ?>')">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </td> -->


            </tr>
            <?php endwhile; ?>
        </tbody>

    </table>
    <a href="../admin/empleados.php">HOLA</a>

    <button id="btnNuevoEmpleado">Nuevo Empleado</button>

    <!-- Modal para agregar nuevo empleado -->
    <div id="modalEmpleado" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Agregar Empleado</h2>
            <form id="formNuevoEmpleado">
                <label for="nombreEmpleado">Nombre:</label>
                <input type="text" id="nombreEmpleado" name="nombreEmpleado" required />

                <label for="apellidoEmpleado">Apellidos:</label>
                <input type="text" id="apellidoEmpleado" name="apellidoEmpleado" required />

                <label for="correoEmpleado">Correo:</label>
                <input type="email" id="correoEmpleado" name="correoEmpleado" required />

                <label for="rolEmpleado">Rol:</label>
                <select id="rolEmpleado" name="rolEmpleado" required>
                    <option value="">Selecciona un rol</option>
                    <option value="Admin">Administrador</option>
                    <option value="Empleado">Recepcionista</option>
                    <!-- Puedes agregar más opciones según sea necesario -->
                </select>

                <label for="telefonoEmpleado">Teléfono:</label>
                <input type="number" id="telefonoEmpleado" name="telefonoEmpleado" required />

                <label for="passwordEmpleado">Contraseña:</label>
                <input type="password" id="passwordEmpleado" name="passwordEmpleado"
                    title="La contraseña debe tener al menos 8 caracteres
                     una letra mayúscula
                      una minúscula y un número."
                    required />

                <label for="fechaIngresoEmpleado">Fecha de Ingreso:</label>
                <input type="date" id="fechaIngresoEmpleado" name="fechaIngresoEmpleado" required />

                <button type="submit" style="margin-top: 10px;" id="Guardar">Guardar</button>

            </form>
        </div>
    </div>
</div>
</body>
<script src="../js/scripts.js"></script>


<?php include "../admin/includes/footer.php" ?>


<script src="../js/scripts.js"></script>
<script>
// Manejo de modal
const modalaggEmpleado = document.getElementById("modalEmpleado");
const btnAggEmpleado = document.getElementById("btnNuevoEmpleado");
var span = document.getElementsByClassName("close")[0];

btnAggEmpleado.onclick = function() {
    modalaggEmpleado.style.display = "block";
};

span.onclick = function() {
    modalaggEmpleado.style.display = "none";
};

window.onclick = function(event) {
    if (event.target == modalaggEmpleado) {
        modalaggEmpleado.style.display = "none";
    }
}

// Validación del formulario antes de enviarlo
$(document).ready(function() {
    $('#Guardar').click(function(e) {
        e.preventDefault();

        var nombre = $('#nombreEmpleado').val().trim();
        var apellidos = $('#apellidoEmpleado').val().trim();
        var correo = $('#correoEmpleado').val().trim();
        var rol = $('#rolEmpleado').val().trim();
        var telefono = $('#telefonoEmpleado').val().trim();
        var password = $('#passwordEmpleado').val().trim();
        var fecha = $('#fechaIngresoEmpleado').val().trim();

        if (nombre === '' || apellidos === '' || correo === '' || rol === '' || telefono === '' ||
            password === '' || fecha === '') {
            Swal.fire({
                title: 'Error',
                text: 'Todos los campos son obligatorios',
                icon: 'error'
            });
            return;
        }
        var telefonoPattern = /^\d{8}$/;
        if (!telefonoPattern.test(telefono)) {
            Swal.fire({
                title: 'Error',
                text: 'Ingrese un telefono valido',
                icon: 'error'
            });
            return;
        }
        var passwordError = /^\d{8}$/;
        if (!passwordError.test(password)) {
            Swal.fire({
                title: 'Error',
                text: 'Ingrese una Contraseña valida',
                icon: 'error'
            })
            return;
        }
        $.ajax({
            type: 'POST',
            url: '../admin/consultas/AgregarEmpleado.php',
            data: {
                nombre: nombre,
                apellidos: apellidos,
                telefono: telefono,
                correo: correo,
                rol: rol,
                telefono: telefono,
                password: password,
                fecha: fecha
            },
            success: function(data) {
                Swal.fire({
                    title: '¡Mensaje!',
                    text: data,
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location = "../admin/empleados.php";
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: 'Error',
                    text: xhr.responseText,
                    icon: 'error'
                });
            },
            complete: function() {
                $('#Guardar').prop('disabled',
                false); // Enable the button after request completion
            }
        })
    });
});

// Script Fecha actual
document.addEventListener("DOMContentLoaded", function() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0'); // Día con dos dígitos
    var mm = String(today.getMonth() + 1).padStart(2, '0'); // Mes con dos dígitos
    var yyyy = today.getFullYear(); // Año en 4 dígitos

    today = yyyy + '-' + mm + '-' + dd; // Formato: YYYY-MM-DD

    document.getElementById("fechaIngresoEmpleado").value = today;
});
</script>


</html>