<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agregar participantes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      max-width: 600px;
    }
    .btn-primary {
      background-color: #28a745;
      border-color: #28a745;
    }
    .btn-primary:hover {
      background-color: #218838;
      border-color: #1e7e34;
    }
    .card {
      border: none;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="card">
      <div class="card-body">
        <h1 class="card-title text-center mb-4">Agregar participantes</h1>

        <?php
        // Obtener ID del evento
        $idEvento = $_GET['id_evento'];

        // Conectarse a la base de datos
        $db = new mysqli('localhost', 'root', '', 'desarrollo_eventos');

        // Consultar datos del evento
        $consultaEvento = "SELECT titulo, iniciador, fecha, hora, ubicacion FROM eventos WHERE id_evento = ?";
        $stmtEvento = $db->prepare($consultaEvento);
        $stmtEvento->bind_param('i', $idEvento);
        $stmtEvento->execute();
        $stmtEvento->bind_result($tituloEvento, $iniciador, $fechaEvento, $horaEvento, $ubicacionEvento);
        $stmtEvento->fetch();
        $stmtEvento->close();
        ?>

        <div class="mb-4">
          <h2 class="h4">Evento: <?php echo htmlspecialchars($tituloEvento); ?></h2>
          <h3 class="h5">Iniciador: <?php echo htmlspecialchars($iniciador); ?></h3>
          <p class="mb-1">Fecha: <?php echo htmlspecialchars($fechaEvento); ?> - Hora: <?php echo htmlspecialchars($horaEvento); ?></p>
          <p>Ubicación: <?php echo htmlspecialchars($ubicacionEvento); ?></p>
        </div>

        <form action="guardar_participantes.php" method="post">
          <input type="hidden" name="id_evento" value="<?php echo htmlspecialchars($idEvento); ?>">

          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>

          <div class="mb-3">
            <label for="identificación" class="form-label">Identificación:</label>
            <input type="text" class="form-control" id="identificación" name="identificación" required>
          </div>

          <div class="mb-3">
            <label for="correo" class="form-label">Correo electrónico:</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-primary">Agregar participante</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>