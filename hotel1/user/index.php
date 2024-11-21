<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache"); // Para versiones antiguas de HTTP (HTTP/1.0)
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT"); 
session_start();

if (!isset($_SESSION['nivel_acceso'])) {
    echo "<script language='JavaScript'>
            alert('Error: Debes iniciar sesión primero.');
            window.location.href = '../../hotel1/index.php';  // Redirige al login
          </script>";
    exit();
}

if ($_SESSION['nivel_acceso'] !== 'recepcionista') {
    echo "<script language='JavaScript'>
            alert('Error: No tienes permisos para acceder a esta página.');
            window.history.back();  // Regresa a la página anterior (dashboard o donde estaba)
          </script>";
    exit();  
}

if (!isset($_SESSION['nombre_empleado'])) {
    echo "<script language='JavaScript'>
            alert('Error: Usuario no autenticado. Debes iniciar sesión primero.');
            window.location.href = '../../hotel1/index.php';  // Redirige al login
          </script>";
    exit();
}
$id_empleado = $_SESSION['empleado_id'];
$nombreUsuario = $_SESSION['nombre_empleado'];
$nivelAcceso = $_SESSION['nivel_acceso'];

if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 3000) {  // 3000 segundos = 50 minutos
    session_unset();  
    session_destroy();  
    echo "<script language='JavaScript'>
            alert('Error: La sesión ha expirado.');
            window.location.href = '../../hotel1/index.php';  // Redirige al login
          </script>";
    exit();  
} else {
    $_SESSION['last_activity'] = time();  
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOTEL</title>

    <!-- Estilos y scripts necesarios -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.4/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a9f6dfd024.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../user/css_user/style_index.css">
</head>
<header>
    <nav class="navbar">
        <div class="contenerdor-navbar">
            <img src="../user/imagenes/logo.jpg" alt="Logo" class="logo-img">
            <h2>Bienvenido <?php echo $nombreUsuario; ?></h2>
            <a id="cerrarsesion" ><i class="fa-solid fa-power-off"></i></a>
        </div>
    </nav>
</header>

<body>

    <div class="conteiner">
        <div class="contenedor-botones">
            <div class="recepcion" id="recepcion" onclick="redirigir('recepcion');">
                <i class="fa-solid fa-hotel"></i>
                <h2>Recepcion </h2>
            </div>
            <div class="recepcion" id="apertura" onclick="redirigir('apertura');">
                <i class="fas fa-wallet"></i>
                <h2>Apertura</h2>
            </div>
            <div class="recepcion" id="cierre" onclick="redirigir('cierre');">
                <i class="fas fa-money-check-alt"></i>
                <h2>Cierre</h2>
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
    </div>



</body>
<script src="https://kit.fontawesome.com/a9f6dfd024.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.semanticui.js"></script>

<script>
    function redirigir(id) {
        switch (id) {
            case "recepcion":
                window.location.href = "../user/recepcion.php";
                break;
            case "apertura":
                window.location.href = "../user/caja_apertura.php";
                break;
            case "cierre":
                window.location.href = "../user/caja_cierre.php";
                break;
            default:
                console.log("Botón no definido");
        }
    };
    $('#cerrarsesion').click(function(e) {
        Swal.fire({
            title: 'Cerrar sesión',
            text: '¿Esta seguro de cerrar sesión?',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonText: 'Si, Cerrar Sesion',
            icon: "question"
        }).then((result) =>{
            if (result.isConfirmed) {
                location.href = '../validacion/cerrarsesion.php';
            }
        });
    });
</script>

</html>