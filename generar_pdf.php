<?php

// Configurar la codificación de caracteres
header('Content-Type: text/html; charset=utf-8');

// Obtener ID del evento
$idEvento = $_GET['id_evento'];

// Conectarse a la base de datos
$db = new mysqli('localhost', 'root', '', 'corhuila');
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

class PDF extends FPDF
{
    function Header()
    {
        // Logo
        $this->Image('assets/CORHUILA5.png', 10, 6, 50);
        // Fuente
        $this->SetFont('Arial', 'B', 20);
        $this->SetTextColor(76, 175, 80); // Color verde (RGB)
        // Mover a la derecha
        $this->Cell(20);
        // Título
        $this->Cell(0, 20, 'EVENTO CORHUILA', 0, 0, 'C');
        // Salto de línea
        $this->Ln(35); // Aumentado para dar más espacio
        // Resetear el color del texto para el resto del documento
        $this->SetTextColor(0);
    }

    function Footer()
    {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Fuente
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(10, 20, 10);
$pdf->SetTextColor(COLOR_TEXTO[0], COLOR_TEXTO[1], COLOR_TEXTO[2]);

// Información del evento
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetFillColor(COLOR_VERDE[0], COLOR_VERDE[1], COLOR_VERDE[2]);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(0, 10, utf8_to_latin1($tituloEvento), 0, 1, 'C', true);
$pdf->SetTextColor(COLOR_TEXTO[0], COLOR_TEXTO[1], COLOR_TEXTO[2]);

$pdf->SetFont('Arial', 'B', 12);
$pdf->Ln(5);

$pdf->Cell(40, 10, 'Iniciador:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_to_latin1($iniciadorEvento), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Cargo:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_to_latin1($cargoEvento), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Fecha y Hora:', 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_to_latin1($fechaEvento . ' - ' . $horaEvento_ampm), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, utf8_to_latin1('Ubicación:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, utf8_to_latin1($ubicacionEvento), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, utf8_to_latin1('Descripción:'), 0, 0, 'L');
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 10, utf8_to_latin1($descripcionEvento), 0, 'L');

// Tabla de participantes
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetFillColor(COLOR_VERDE[0], COLOR_VERDE[1], COLOR_VERDE[2]);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(0, 10, 'Participantes', 0, 1, 'C', true);
$pdf->SetFont('Arial', '', 10);
$pdf->SetTextColor(COLOR_TEXTO[0], COLOR_TEXTO[1], COLOR_TEXTO[2]);

// Encabezado de la tabla
$pdf->SetFillColor(COLOR_GRIS[0], COLOR_GRIS[1], COLOR_GRIS[2]);
$pdf->Cell(60, 10, 'Nombre', 0, 0, 'C', true);
$pdf->Cell(40, 10, utf8_to_latin1('Identificación'), 0, 0, 'C', true);
$pdf->Cell(0, 10, utf8_to_latin1('Correo electrónico'), 0, 1, 'C', true);

// Filas de la tabla
$fill = false;
while ($stmtParticipantes->fetch()) {
    $pdf->SetFillColor($fill ? 245 : 255, $fill ? 245 : 255, $fill ? 245 : 255);
    $pdf->Cell(60, 10, utf8_to_latin1($nombreParticipante), 0, 0, 'L', $fill);
    $pdf->Cell(40, 10, utf8_to_latin1($identificacionParticipante), 0, 0, 'L', $fill);
    $pdf->Cell(0, 10, utf8_to_latin1($correoParticipante), 0, 1, 'L', $fill);
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