<?php
require __DIR__ . '/fpdf186/fpdf.php';

if (!isset($_POST['cajaInfo'])) {
    echo json_encode(['success' => false, 'error' => 'No se recibió información de la caja.']);
    exit;
}

$cajaInfo = json_decode($_POST['cajaInfo'], true);  // Decodificar JSON correctamente

if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'error' => 'Error en el formato de datos de la caja.']);
    exit;
}

try {
    // Inicializa el PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    $pdf->Cell(0, 10, 'Reporte de Cierre de Caja', 1, 1, 'C');
    $pdf->Ln(10);

    // Mostrar los datos de la caja
    foreach ($cajaInfo as $key => $value) {
        $pdf->Cell(50, 10, ucfirst(str_replace('_', ' ', $key)) . ':', 1);
        $pdf->Cell(0, 10, $value, 1, 1);
    }

    // Guardar el archivo PDF en el servidor
    $pdfOutput = 'pdfs/caja_' . $cajaInfo['caja_id'] . '.pdf';
    $pdf->Output('F', $pdfOutput);

    echo json_encode(['success' => true, 'pdf_url' => $pdfOutput]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
