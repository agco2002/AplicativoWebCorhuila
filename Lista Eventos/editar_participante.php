<?php
// Obtener ID del evento y ID del participante
$idEvento = $_GET['id_evento'];
$idParticipante = $_GET['id_participante'];

// Conectarse a la base de datos
$db = new mysqli('localhost', 'root', '', 'corhuila');

// Recuperar datos del participante actual
$consultaParticipante = "SELECT nombre, identificación, correo FROM participantes WHERE id_participante = ? AND id_evento = ?";
$stmtParticipante = $db->prepare($consultaParticipante);
$stmtParticipante->bind_param('ii', $idParticipante, $idEvento);
$stmtParticipante->execute();
$stmtParticipante->bind_result($nombre, $identificación, $correo);
$stmtParticipante->fetch();
$stmtParticipante->close();

$db->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Participante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .form-container {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 100%;
        }
        .btn-custom {
            background-color: #28a745;
            border-color: #28a745;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #218838;
            border-color: #1e7e34;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1 class="text-center mb-4">Editar Participante</h1>
        <form action="actualizar_participante.php" method="post">
            <input type="hidden" name="id_evento" value="<?php echo htmlspecialchars($idEvento); ?>">
            <input type="hidden" name="id_participante" value="<?php echo htmlspecialchars($idParticipante); ?>">
            
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="identificación" class="form-label">Identificación:</label>
                <input type="text" class="form-control" id="identificación" name="identificación" value="<?php echo htmlspecialchars($identificación); ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="correo" class="form-label">Correo electrónico:</label>
                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($correo); ?>" required>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-custom btn-lg">Actualizar Participante</button>
            </div>
        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



    