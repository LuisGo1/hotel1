<?php
include ("../../conecction/db.php");
// Obtener los datos JSON enviados desde el cliente
$data = json_decode(file_get_contents('php://input'), true);

// Verificar si se ha recibido el id_habitacion
if (isset($data['id_habitacion'])) {
    $id_habitacion = $data['id_habitacion'];
    
    // Aquí puedes consultar la base de datos usando el id_habitacion
    // Ejemplo de consulta (ajusta a tu estructura de base de datos)
    $query = "SELECT * 
    FROM check_in_out AS chk
    JOIN habitaciones AS hab 
    ON chk.id_habitacion = hab.cuarto_id
    JOIN clientes as clt ON clt.cliente_id=chk.id_cliente
    WHERE hab.cuarto_id = '$id_habitacion'
    ORDER BY chk.fecha_check_in DESC
    LIMIT 1";
    // Suponiendo que tengas una conexión a la base de datos:
    $result = mysqli_query($conexion, $query);
    
    if ($result) {
        $habitacion = mysqli_fetch_assoc($result);
        echo json_encode($habitacion);  // Enviar los datos como respuesta JSON
    } else {
        echo json_encode(["error" => "No se encontró la habitación"]);
    }
} else {
    echo json_encode(["error" => "ID de habitación no proporcionado"]);
}
?>
