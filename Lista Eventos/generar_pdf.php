<?php

// Configurar la codificación de caracteres
header('Content-Type: text/html; charset=utf-8');

// Obtener ID del evento
$idEvento = $_GET['id_evento'];

// Conectarse a la base de datos
$db = new mysqli('localhost', 'root', '', 'desarrollo_eventos');
$db->set_charset("utf8mb4");

// Función para convertir UTF-8 a ISO-8859-1
function utf8_to_latin1($str) {
    return iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $str);
}

// Consultar datos del evento
$consultaEvento = "SELECT titulo, iniciador, cargo, descripcion, fecha, hora, ubicacion FROM eventos WHERE id_evento = ?";
$stmtEvento = $db->prepare($consultaEvento);
$stmtEvento->bind_param('i', $idEvento);
$stmtEvento->execute();
$stmtEvento->bind_result($tituloEvento, $iniciadorEvento, $cargoEvento, $descripcionEvento, $fechaEvento, $horaEvento, $ubicacionEvento);
$stmtEvento->fetch();
$stmtEvento->close();

// Convertir hora a formato AM/PM
$horaEvento_ampm = date("h:i A", strtotime($horaEvento));

// Consultar datos de los participantes
$consultaParticipantes = "SELECT nombre, identificación, correo FROM participantes WHERE id_evento = ?";
$stmtParticipantes = $db->prepare($consultaParticipantes);
$stmtParticipantes->bind_param('i', $idEvento);
$stmtParticipantes->execute();
$stmtParticipantes->bind_result($nombreParticipante, $identificacionParticipante, $correoParticipante);

// Generar PDF
require_once('fpdf/fpdf.php');

// Definir colores
define('COLOR_VERDE', array(76, 175, 80));
define('COLOR_GRIS', array(224, 224, 224));
define('COLOR_TEXTO', array(33, 33, 33));

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetMargins(10, 20, 10); // Reducir márgenes laterales
$pdf->SetTextColor(COLOR_TEXTO[0], COLOR_TEXTO[1], COLOR_TEXTO[2]);

// Información del evento
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(0, 15, utf8_to_latin1($tituloEvento), 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_to_latin1('Iniciador: ' . $iniciadorEvento), 0, 1);
$pdf->Cell(0, 10, utf8_to_latin1('Cargo: ' . $cargoEvento), 0, 1);
$pdf->Cell(0, 10, utf8_to_latin1('Fecha: ' . $fechaEvento . ' - Hora: ' . $horaEvento_ampm), 0, 1);
$pdf->Cell(0, 10, utf8_to_latin1('Ubicación: ' . $ubicacionEvento), 0, 1);
$pdf->MultiCell(0, 10, utf8_to_latin1('Descripción: ' . $descripcionEvento), 0, 'L');
// Tabla de participantes
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, utf8_to_latin1('Participantes'), 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);

// Calcular ancho de columnas y posición inicial para centrar
$w1 = 50; // Ancho de la columna Nombre
$w2 = 40; // Ancho de la columna Identificación
$w3 = 60; // Ancho de la columna Correo electrónico
$total_width = $w1 + $w2 + $w3;
$left_margin = ($pdf->GetPageWidth() - $total_width) / 2;

// Encabezado de la tabla
$pdf->SetFillColor(COLOR_VERDE[0], COLOR_VERDE[1], COLOR_VERDE[2]);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetX($left_margin);
$pdf->Cell($w1, 10, utf8_to_latin1('Nombre'), 1, 0, 'C', true);
$pdf->Cell($w2, 10, utf8_to_latin1('Identificación'), 1, 0, 'C', true);
$pdf->Cell($w3, 10, utf8_to_latin1('Correo electrónico'), 1, 1, 'C', true);

// Filas de la tabla
$pdf->SetTextColor(COLOR_TEXTO[0], COLOR_TEXTO[1], COLOR_TEXTO[2]);
$fill = false;
while ($stmtParticipantes->fetch()) {
    $pdf->SetX($left_margin);
    $pdf->SetFillColor($fill ? COLOR_GRIS[0] : 255, $fill ? COLOR_GRIS[1] : 255, $fill ? COLOR_GRIS[2] : 255);
    $pdf->Cell($w1, 10, utf8_to_latin1($nombreParticipante), 1, 0, 'L', $fill);
    $pdf->Cell($w2, 10, utf8_to_latin1($identificacionParticipante), 1, 0, 'L', $fill);
    $pdf->Cell($w3, 10, utf8_to_latin1($correoParticipante), 1, 1, 'L', $fill);
    $fill = !$fill;
}


// Generar un nombre de archivo único
$filename = 'evento_' . $idEvento . '_' . date('YmdHis') . '.pdf';

// Enviar el PDF directamente al navegador
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: private, max-age=0, must-revalidate');
header('Pragma: public');

$pdf->Output('I', $filename);

$stmtParticipantes->close();
$db->close();

exit;
?>




