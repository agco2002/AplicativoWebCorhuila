<?php
// Obtener datos del formulario
$idEvento = $_POST['id_evento'];
$idParticipante = $_POST['id_participante'];
$nombre = $_POST['nombre'];
$identificación = $_POST['identificación'];
$correo = $_POST['correo'];

// Conectarse a la base de datos
$db = new mysqli('localhost', 'root', '', 'corhuila');

// Actualizar participante en la base de datos
$consultaActualizarParticipante = "UPDATE participantes SET nombre = ?, identificación = ?, correo = ? WHERE id_participante = ? AND id_evento = ?";
$stmtActualizarParticipante = $db->prepare($consultaActualizarParticipante);
$stmtActualizarParticipante->bind_param('sssii', $nombre, $identificación, $correo, $idParticipante, $idEvento);
$stmtActualizarParticipante->execute();

if ($stmtActualizarParticipante->affected_rows === 1) {
    echo "Participante actualizado correctamente. <a href='ver_evento.php?id_evento=$idEvento'>Volver</a>";
} else {
    echo "Error al actualizar el participante: " . $db->error;
}