<?php
// Obtener datos del formulario
$idEvento = $_POST['id_evento'];
$titulo = $_POST['titulo'];
$iniciador = $_POST['iniciador'];
$cargo = $_POST['cargo'];
$descripcion = $_POST['descripcion'];
$fecha = $_POST['fecha'];
$hora_ampm = $_POST['hora'];
$ubicacion = $_POST['ubicacion'];

// Convertir la hora de formato AM/PM a formato de 24 horas
$hora_24 = date("H:i", strtotime($hora_ampm));

// Conectarse a la base de datos
$db = new mysqli('localhost', 'root', '', 'corhuila');

// Actualizar evento en la base de datos
$consulta = "UPDATE eventos SET titulo = ?, iniciador = ?, cargo = ?, descripcion = ?, fecha = ?, hora = ?, ubicacion = ? 
WHERE id_evento = ?";
$stmt = $db->prepare($consulta);
$stmt->bind_param('sssssssi', $titulo, $iniciador, $cargo, $descripcion, $fecha, $hora_24, $ubicacion, $idEvento);
$stmt->execute();

if ($stmt->affected_rows === 1) {
    echo "Evento actualizado correctamente.";
    // Redireccionar al usuario (ej: ver_evento.php)
    header('Location: ../ver_evento.php?id_evento=' . $idEvento);
} else {
    echo "Error al actualizar el evento: " . $db->error;
}

$stmt->close();
$db->close();
?>