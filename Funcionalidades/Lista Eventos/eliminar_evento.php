<?php
// Obtener ID del evento
$idEvento = $_GET['id_evento'];

// Conectarse a la base de datos
$db = new mysqli('localhost', 'root', '', 'desarrollo_eventos');

// Verificar la conexión
if ($db->connect_error) {
    die("Error de conexión: " . $db->connect_error);
}

// Iniciar transacción
$db->begin_transaction();

try {
    // Eliminar participantes del evento
    $consultaEliminarParticipantes = "DELETE FROM participantes WHERE id_evento = ?";
    $stmtEliminarParticipantes = $db->prepare($consultaEliminarParticipantes);
    $stmtEliminarParticipantes->bind_param('i', $idEvento);
    $stmtEliminarParticipantes->execute();

    // Eliminar evento
    $consultaEliminarEvento = "DELETE FROM eventos WHERE id_evento = ?";
    $stmtEliminarEvento = $db->prepare($consultaEliminarEvento);
    $stmtEliminarEvento->bind_param('i', $idEvento);
    $stmtEliminarEvento->execute();

    // Verificar si se eliminó el evento
    if ($stmtEliminarEvento->affected_rows === 1) {
        // Evento eliminado correctamente, confirmar transacción
        $db->commit();
        echo "Evento y sus participantes (si los había) eliminados correctamente.";
        header("refresh:3;url=mostrar_eventos.php"); // Redireccionar después de 3 segundos
    } else {
        // No se encontró el evento, hacer rollback
        throw new Exception("No se encontró el evento para eliminar.");
    }
} catch (Exception $e) {
    // Error al eliminar, hacer rollback
    $db->rollback();
    echo "Error: " . $e->getMessage();
}

// Cerrar consultas y conexión
$stmtEliminarParticipantes->close();
$stmtEliminarEvento->close();
$db->close();
?>