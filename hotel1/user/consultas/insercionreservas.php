<?php
include "../../conecction/db.php";

$requiredFields = [
    'id',
    'id_cuarto',
    'nombre',        
    'apellidos',     
    'correo',        
    'telefono',      
    'direccion',     
    'cantidad',
    'fecha'

];

foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        echo json_encode(['success' => false, 'error' => "El campo '$field' está vacío o no fue enviado."]);
        exit;  
    }
}

$empleadoId = $_POST['id'];  
$cuartoId = $_POST['id_cuarto'];  
$nombre = $_POST['nombre'];  
$apellidos = $_POST['apellidos'];  
$correo = $_POST['correo'];  
$telefono = $_POST['telefono']; 
$direccion = $_POST['direccion']; 
$cantidad = $_POST['cantidad'];  
$cantDias = $_POST['cantidad'];  
$fecha = $_POST['fecha'];
$fechaCheckIn = date('Y-m-d H:i:s');  

$comentarios = isset($_POST['comentarios']) ? $_POST['comentarios'] : null;

$conexion->begin_transaction();

try {
    $query = "SELECT * FROM clientes WHERE nombre_cliente = ? AND apellido_cliente = ?";
    $stmt = $conexion->prepare($query);
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . $conexion->error);
    }

    $stmt->bind_param("ss", $nombre, $apellidos);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cliente = $result->fetch_assoc();
        $clienteId = $cliente['cliente_id'];  // ID del cliente
    } else {
        $insertClienteQuery = "INSERT INTO clientes (nombre_cliente, apellido_cliente, telefono, email, direccion, comentarios, fecha_registro, id_empleado) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $insertClienteStmt = $conexion->prepare($insertClienteQuery);
        if (!$insertClienteStmt) {
            throw new Exception("Error al preparar la consulta de inserción del cliente: " . $conexion->error);
        }

        $insertClienteStmt->bind_param("sssssssi", $nombre, $apellidos, $telefono, $correo, $direccion, $comentarios, $fechaCheckIn, $empleadoId);

        if (!$insertClienteStmt->execute()) {
            throw new Exception("Error al insertar el cliente.");
        }

        $clienteId = $conexion->insert_id;  
    }

    $insertCheckInOutQuery = "INSERT INTO reservas( id_cliente, cuarto_id, num_huespedes, estado,  fecha_ingreso, empleado_id)
                              VALUES (?, ?, ?, 'confirmada', ?, ?)";
    $insertCheckInOutStmt = $conexion->prepare($insertCheckInOutQuery);
    if (!$insertCheckInOutStmt) {
        throw new Exception("Error al preparar la consulta de inserción en check_in_out: " . $conexion->error);
    }
    $insertCheckInOutStmt->bind_param("iiisi", $clienteId, $cuartoId, $cantDias, $fecha, $empleadoId);

    if (!$insertCheckInOutStmt->execute()) {
        throw new Exception("Error al insertar en check_in_out.");
    }

    $updateHabitacionQuery = "UPDATE habitaciones SET estado = 'reservado' WHERE cuarto_id = ?";
    $updateHabitacionStmt = $conexion->prepare($updateHabitacionQuery);
    if (!$updateHabitacionStmt) {
        throw new Exception("Error al preparar la consulta de actualización de habitación: " . $conexion->error);
    }
    $updateHabitacionStmt->bind_param("i", $cuartoId);

    if (!$updateHabitacionStmt->execute()) {
        throw new Exception("Error al actualizar el estado de la habitación.");
    }

    $conexion->commit();

    echo json_encode(['success' => true, 'message' => 'Reserva, check-in y actualización de habitación realizados correctamente.']);
} catch (Exception $e) {
    $conexion->rollback();

    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
