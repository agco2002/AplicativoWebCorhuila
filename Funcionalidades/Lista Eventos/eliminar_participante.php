<?php
// Obtener ID del evento y ID del participante
$idEvento = $_GET['id_evento'];
$idParticipante = $_GET['id_participante'];

// Conectarse a la base de datos
$db = new mysqli('localhost', 'root', '', 'desarrollo_eventos');

// Eliminar participante de la base de datos
$consultaEliminarParticipante = "DELETE FROM participantes WHERE id_participante = ? AND id_evento = ?";
$stmtEliminarParticipante = $db->prepare($consultaEliminarParticipante);
$stmtEliminarParticipante->bind_param('ii', $idParticipante, $idEvento);
$stmtEliminarParticipante->execute();

if ($stmtEliminarParticipante->affected_rows === 1) {
    echo "Participante eliminado correctamente. <a href='ver_evento.php?id_evento=$idEvento'>Volver</a>";
} else {
    echo "Error al eliminar el participante: " . $db->error;
}

$stmtEliminarParticipante->close();
$db->close();
?>
