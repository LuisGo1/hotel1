<?php
include("../conecction/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero_habitacion = $_POST['numero_habitacion'];
    $tipo_habitacion = $_POST['tipo_habitacion'];
    $descripcion = $_POST['descripcion'];
    $capacidad = $_POST['capacidad'];
    $precio_noche = $_POST['precio_noche'];
    $estado = $_POST['estado'];
    $fecha_registro = $_POST['fecha_registro'];
    $id_nivel = $_POST['nivel'];

    // Validar que no se duplique el número de habitación
    $consulta = $conexion->prepare("SELECT * FROM habitaciones WHERE numero_habitacion = ?");
    $consulta->bind_param("i", $numero_habitacion);
    $consulta->execute();
    $resultado = $consulta->get_result();

    if ($resultado->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "El número de habitación ya existe."]);
    } else {
        // Insertar la nueva habitación
        $stmt = $conexion->prepare("INSERT INTO habitaciones (numero_habitacion, tipo_habitacion, descripcion, capacidad, precio_noche, estado, fecha_registro, id_nivel) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssisss", $numero_habitacion, $tipo_habitacion, $descripcion, $capacidad, $precio_noche, $estado, $fecha_registro, $id_nivel);

        if ($stmt->execute()) {
            // Enviar respuesta con los datos de la nueva habitación
            $cuarto_id = $stmt->insert_id;
            echo json_encode([
                "success" => true,
                "data" => [
                    "cuarto_id" => $cuarto_id,
                    "numero_habitacion" => $numero_habitacion,
                    "tipo_habitacion" => $tipo_habitacion,
                    "descripcion" => $descripcion,
                    "capacidad" => $capacidad,
                    "precio_noche" => $precio_noche,
                    "estado" => $estado,
                    "fecha_registro" => $fecha_registro,
                    "id_nivel" => $id_nivel,
                ]
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al insertar la habitación."]);
        }
    }
    $conexion->close();
}
?>
