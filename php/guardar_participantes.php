<?php
header('Content-Type: application/json');

// Obtener datos del formulario
if (isset($_POST['id_evento']) && isset($_POST['nombre']) && isset($_POST['identificación']) && isset($_POST['correo'])) {
  $idEvento = $_POST['id_evento'];
  $nombre = $_POST['nombre'];
  $identificación = $_POST['identificación'];
  $correo = $_POST['correo'];

  // Conectarse a la base de datos
  $db = new mysqli('localhost', 'root', '', 'corhuila');

  // Guardar participante en la base de datos
  $consulta = "INSERT INTO participantes (id_evento, nombre, identificación, correo) VALUES (?, ?, ?, ?)";
  $stmt = $db->prepare($consulta);
  $stmt->bind_param('isss', $idEvento, $nombre, $identificación, $correo);
  $stmt->execute();

  if ($stmt->affected_rows === 1) {
    echo json_encode([
      'status' => 'success',
      'message' => 'Participante agregado correctamente.',
      'redirect' => "ver_evento.php?id_evento=$idEvento"
    ]);
  } else {
    echo json_encode([
      'status' => 'error',
      'message' => 'Error al agregar el participante: ' . $db->error
    ]);
  }

  $stmt->close();
} else {
  echo json_encode([
    'status' => 'error',
    'message' => 'Faltan datos para agregar el participante.'
  ]);
}

$db->close();
?>