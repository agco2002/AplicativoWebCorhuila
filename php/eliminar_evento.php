<?php
// Verificar si se recibió la confirmación
if (!isset($_GET['confirmar']) || $_GET['confirmar'] != '1') {
    header('Location: ../ver_evento.php?id_evento=' . $_GET['id_evento']);
    exit();
}

// Obtener ID del evento
$idEvento = $_GET['id_evento'];

// Conectarse a la base de datos
$db = new mysqli('localhost', 'root', '', 'corhuila');

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
        echo "<script>
                alert('Evento y sus participantes eliminados correctamente.');
                window.location.href = '../mostrar_eventos.php';
              </script>";
    } else {
        // No se encontró el evento, hacer rollback
        throw new Exception("No se encontró el evento para eliminar.");
    }
} catch (Exception $e) {
    // Error al eliminar, hacer rollback
    $db->rollback();
    echo "<script>
            alert('Error: " . $e->getMessage() . "');
            window.location.href = '../ver_evento.php?id_evento=" . $idEvento . "';
          </script>";
}

// Cerrar consultas y conexión
$stmtEliminarParticipantes->close();
$stmtEliminarEvento->close();
$db->close();
?>