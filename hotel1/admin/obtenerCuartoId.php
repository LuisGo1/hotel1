<?php
include("../conecction/db.php");

if (isset($_POST['numero_habitacion'])) {
    $numero_habitacion = $_POST['numero_habitacion'];

    // Buscar el cuarto_id usando el número de habitación
    $consulta = $conexion->prepare("SELECT cuarto_id FROM habitaciones WHERE numero_habitacion = ?");
    $consulta->bind_param("s", $numero_habitacion);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows > 0) {
        // Si se encuentra el número de habitación, devolver el cuarto_id
        $fila = $resultado->fetch_assoc();
        echo json_encode(['success' => true, 'cuarto_id' => $fila['cuarto_id']]);
    } else {
        // Si no se encuentra el número de habitación
        echo json_encode(['success' => false]);
    }

    $consulta->close();
} else {
    echo json_encode(['success' => false]);
}

$conexion->close();
?>
