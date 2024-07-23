guardar_evento.php
<?php
header('Content-Type: application/json');

// Conectarse a la base de datos
$db = new mysqli('localhost', 'root', '', 'corhuila');

// Validar datos del formulario
if (isset($_POST['titulo']) && isset($_POST['iniciador']) && 
    isset($_POST['cargo']) && isset($_POST['descripcion']) && 
    isset($_POST['fecha']) && isset($_POST['hora']) && isset($_POST['ubicacion'])) {
    
    $titulo = $_POST['titulo'];
    $iniciador = $_POST['iniciador'];
    $cargo = $_POST['cargo'];
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha'];
    $hora_ampm = $_POST['hora'];
    $ubicacion = $_POST['ubicacion'];

    // Convertir la hora de formato AM/PM a formato de 24 horas
    $hora_24 = date("H:i", strtotime($hora_ampm));

    // Guardar evento en la base de datos
    $consulta = "INSERT INTO eventos (titulo, iniciador, cargo, descripcion, fecha, hora, ubicacion) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($consulta);
    $stmt->bind_param('sssssss', $titulo, $iniciador, $cargo, $descripcion, $fecha, $hora_24, $ubicacion);
    $stmt->execute();

    if ($stmt->affected_rows === 1) {
        $idEvento = $stmt->insert_id;
        echo json_encode([
            'status' => 'success',
            'message' => 'Evento creado correctamente.',
            'redirect' => "ver_evento.php?id_evento=$idEvento"
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Error al crear el evento: ' . $db->error
        ]);
    }

    $stmt->close();
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Faltan datos para crear el evento.'
    ]);
}

$db->close();
?>