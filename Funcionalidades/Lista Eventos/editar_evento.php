<?php
// Obtener ID del evento
$idEvento = $_GET['id_evento'];

// Conectarse a la base de datos
$db = new mysqli('localhost', 'root', '', 'desarrollo_eventos');

// Recuperar datos del evento
$consulta = "SELECT titulo, iniciador, cargo, descripcion, fecha, hora, ubicacion FROM eventos WHERE id_evento = ?";
$stmt = $db->prepare($consulta);
$stmt->bind_param('i', $idEvento);
$stmt->execute();
$stmt->bind_result($titulo, $iniciador, $cargo, $descripcion, $fecha, $hora, $ubicacion);
$stmt->fetch();
$stmt->close();

// Convertir la hora de formato 24 horas a formato AM/PM
$hora_ampm = date("h:i A", strtotime($hora));

$db->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Evento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
        }
        body {
            display: flex;
            align-items: center;
            background-color: #f8f9fa;
        }
        .form-container {
            width: 100%;
            max-width: 900px;
            margin: auto;
            padding: 20px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .btn-custom {
            background-color: #28a745;
            border-color: #28a745;
            transition: all 0.3s;
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
    <div class="container">
        <div class="form-container">
            <h1 class="text-center mb-4">Editar Evento</h1>
            <form action="actualizar_evento.php" method="post">
                <input type="hidden" name="id_evento" value="<?php echo $idEvento; ?>">
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="titulo" class="form-label">Título:</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $titulo; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="iniciador" class="form-label">Iniciador:</label>
                        <input type="text" class="form-control" id="iniciador" name="iniciador" value="<?php echo $iniciador; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="cargo" class="form-label">Cargo:</label>
                        <input type="text" class="form-control" id="cargo" name="cargo" value="<?php echo $cargo; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="ubicacion" class="form-label">Ubicación:</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="<?php echo $ubicacion; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="fecha" class="form-label">Fecha:</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $fecha; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="hora" class="form-label">Hora:</label>
                        <input type="text" class="form-control" id="hora" name="hora" value="<?php echo $hora_ampm; ?>" pattern="(0[1-9]|1[0-2]):[0-5][0-9] (AM|PM)" placeholder="hh:mm AM/PM" required>
                    </div>
                    <div class="col-12">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo $descripcion; ?></textarea>
                    </div>
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-custom btn-lg">Actualizar Evento</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>