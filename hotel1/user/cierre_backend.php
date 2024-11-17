<?php
session_start();
include("../conecction/db.php");

// Verificar que el usuario esté logueado
if (!isset($_SESSION['empleado_id'])) {
    echo json_encode(['success' => false, 'error' => 'No autorizado.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que los datos necesarios están presentes y son correctos
    if (isset($_POST['montoCierre']) && is_numeric($_POST['montoCierre']) && $_POST['montoCierre'] > 0) {
        $empleado_id = $_SESSION['empleado_id'];
        $fecha_cierre = date('Y-m-d H:i:s'); // Fecha y hora actual
        $monto_cierre = floatval($_POST['montoCierre']); // Convertir el monto a decimal

        // Iniciar una transacción para asegurar que los cambios sean atómicos
        $conexion->begin_transaction();

        try {
            // Consultar si existe una caja abierta para este empleado
            $query = "SELECT * FROM caja_diaria 
                      WHERE empleado_id = ? 
                      AND estado = 'abierta' 
                      AND DATE(fecha_apertura) = CURDATE()";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("i", $empleado_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $caja = $result->fetch_assoc();
                $caja_id = $caja['caja_id'];
                $total_ingreso_dia = $caja['total_ingreso_dia']; // Traemos el valor actual
                $total_egreso_dia = $caja['total_egreso_dia']; // Traemos el valor actual

                // ** Operación matemática para el cierre **
                $total_ingreso_dia += $monto_cierre; // Agregar el monto del cierre al ingreso del día

                $saldo_final = $total_ingreso_dia - $total_egreso_dia; // Calcular el saldo final

                // Actualizar el registro de la caja
                $update_query = "UPDATE caja_diaria 
                                 SET fecha_cierre = ?, 
                                     monto_cierre = ?, 
                                     saldo_final = ?, 
                                     total_ingreso_dia = ?, 
                                     total_egreso_dia = ?, 
                                     estado = 'cerrada'
                                 WHERE caja_id = ?";
                $update_stmt = $conexion->prepare($update_query);
                $update_stmt->bind_param("sdssdi", $fecha_cierre, $monto_cierre, $saldo_final, $total_ingreso_dia, $total_egreso_dia, $caja_id);

                if ($update_stmt->execute()) {
                    // Confirmar la transacción si la actualización fue exitosa
                    $conexion->commit();
                    echo json_encode(['success' => true, 'message' => 'Caja cerrada correctamente.']);
                } else {
                    // Si ocurre un error en la actualización, revertir los cambios
                    $conexion->rollback();
                    echo json_encode(['success' => false, 'error' => 'Error al cerrar la caja.']);
                }

                $update_stmt->close();
            } else {
                echo json_encode(['success' => false, 'error' => 'No se encontró una caja abierta para el usuario.']);
            }

            $stmt->close();
        } catch (Exception $e) {
            // Si ocurre una excepción, revertir la transacción
            $conexion->rollback();
            echo json_encode(['success' => false, 'error' => 'Error interno en el servidor.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Monto de cierre inválido o faltante.']);
    }
}

$conexion->close();
?>

