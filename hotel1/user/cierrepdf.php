<?php
require __DIR__ . '/fpdf186/fpdf.php';

if (!isset($_POST['cajaInfo'])) {
    echo json_encode(['success' => false, 'error' => 'No se recibió información de la caja.']);
    exit;
}

// Decodificar JSON correctamente
$cajaInfo = json_decode($_POST['cajaInfo'], true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'error' => 'Error en el formato de datos de la caja.']);
    exit;
}

try {
    // Validar que los datos esenciales están presentes
    $requiredFields = ['caja_id', 'fecha_apertura', 'monto_apertura', 'fecha_cierre', 'monto_cierre', 'total_ingreso_dia', 'total_egreso_dia', 'saldo_final', 'estado', 'empleado_id'];
    foreach ($requiredFields as $field) {
        if (!isset($cajaInfo[$field])) {
            echo json_encode(['success' => false, 'error' => "Falta el campo requerido: $field"]);
            exit;
        }
    }

    // Verificar y crear el directorio para guardar PDFs
    $pdfDir = __DIR__ . '/pdfs';
    if (!is_dir($pdfDir)) {
        mkdir($pdfDir, 0755, true);  // Crear el directorio si no existe
    }

    // Inicializar el PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Encabezado
    $pdf->SetFillColor(230, 230, 230); // Color de fondo gris claro
    $pdf->Cell(0, 10, 'Reporte de Cierre de Caja', 0, 1, 'C', true);
    $pdf->Ln(10);

    // Logo (opcional, descomentar si tienes un logo)
    // $pdf->Image('ruta_del_logo.jpg', 10, 10, 30);
    // $pdf->Ln(30);

    // Información del reporte
    $pdf->SetFont('Arial', '', 12);
    foreach ($cajaInfo as $key => $value) {
        $label = ucfirst(str_replace('_', ' ', $key)); // Formatear claves
        $pdf->Cell(60, 10, $label . ':', 1, 0, 'L', true);
        $pdf->Cell(0, 10, $value, 1, 1, 'L');
    }

    // Guardar el archivo PDF en el servidor
    $pdfOutput = $pdfDir . '/caja_' . $cajaInfo['caja_id'] . '.pdf';
    $pdf->Output('F', $pdfOutput);

    // Devolver éxito y la URL del PDF generado
    echo json_encode(['success' => true, 'pdf_url' => 'http://' . $_SERVER['HTTP_HOST'] . '/hotel1/hotel1/user/pdfs/caja_' . $cajaInfo['caja_id'] . '.pdf']);
} catch (Exception $e) {
    // Manejo de errores
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
