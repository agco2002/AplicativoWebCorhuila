<?php
header('Content-Type: application/json');

// Obtener ID del evento y ID del participante
$idEvento = $_GET['id_evento'];
$idParticipante = $_GET['id_participante'];

// Conectarse a la base de datos
$db = new mysqli('localhost', 'root', '', 'corhuila');

// Eliminar participante de la base de datos
$consultaEliminarParticipante = "DELETE FROM participantes WHERE id_participante = ? AND id_evento = ?";
$stmtEliminarParticipante = $db->prepare($consultaEliminarParticipante);
$stmtEliminarParticipante->bind_param('ii', $idParticipante, $idEvento);
$stmtEliminarParticipante->execute();

if ($stmtEliminarParticipante->affected_rows === 1) {
    echo json_encode(['success' => true, 'message' => 'Participante eliminado correctamente.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al eliminar el participante: ' . $db->error]);
}

$stmtEliminarParticipante->close();
$db->close();
?>