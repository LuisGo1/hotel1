<?php
include "../admin/includes/header.php";
include "../conecction/db.php";
?>
<div></div>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Niveles</title>
    <link rel="stylesheet" href="../css/styles1.css">
</head>

<body>
    <div class="container">


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

        // Cierra la conexión
        $conexion->close();
        ?>

        <section class="rooms">

        </section>

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

    </div>

</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Llamar a la función confirmclic con el primer nivel disponible
        const primerNivel = document.querySelector('.level-card'); // Selecciona el primer nivel
        if (primerNivel) {
            const nivelId = primerNivel.getAttribute('data-id'); // Suponiendo que 'data-id' tiene el id del nivel
            confirmclic(nivelId); // Llamar a la función confirmclic
            // Marcar el primer nivel como seleccionado
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

        fetch('../admin/con_index/obtenerhabitaciones.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'nivel_id=' + nivelId
            })
            .then(response => response.json())
            .then(data => {
                const container = document.querySelector('.rooms');

                container.innerHTML = '';

                if (data.success) {
                    data.habitaciones.forEach(habitacion => {
                        const habitacionDiv = document.createElement('div');
                        habitacionDiv.classList.add('room-card');

                        let estadoClass = '';
                        switch (habitacion.estado) {
                            case 'disponible':
                                estadoClass = 'disponible';
                                break;
                            case 'ocupado':
                                estadoClass = 'ocupado';
                                break;
                            case 'limpieza':
                                estadoClass = 'limpieza';
                                break;
                            case 'mantenimiento':
                                estadoClass = 'mantenimiento';
                                break;
                            case 'reservado':
                                estadoClass = 'reservado';
                                break;
                            default:
                                estadoClass = 'default';
                                break;
                        }

                        
                        habitacionDiv.innerHTML = `
            <h3>${habitacion.tipo_habitacion}</h3>
            <p class="descripcion">${habitacion.descripcion}</p>
            <p class="capacidad">Capacidad: ${habitacion.capacidad}</p>
            <p class="estado"><span class="${estadoClass}">${habitacion.estado}</span></p>
            <p class="price">Precio: $${habitacion.precio_noche}</p>
        `;

                        container.appendChild(habitacionDiv);
                    });


                } else {
                    alert('Error al obtener las habitaciones: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>


</html>