<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear evento</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body, html {
      height: 100%;
    }
    body {
      background-color: #f8f9fa;
      display: flex;
      align-items: center;
    }
    .container {
      max-width: 800px;
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
  <div class="container">
    <div class="card">
      <div class="card-body">
        <h1 class="card-title text-center mb-4">Crear evento</h1>
        <form action="guardar_evento.php" method="post">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="titulo" class="form-label">Título:</label>
              <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            <div class="col-md-6">
              <label for="iniciador" class="form-label">Iniciador:</label>
              <input type="text" class="form-control" id="iniciador" name="iniciador" required>
            </div>
            <div class="col-md-6">
              <label for="cargo" class="form-label">Cargo:</label>
              <input type="text" class="form-control" id="cargo" name="cargo" required>
            </div>
            <div class="col-md-6">
              <label for="ubicacion" class="form-label">Ubicación:</label>
              <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
            </div>
            <div class="col-md-6">
              <label for="fecha" class="form-label">Fecha:</label>
              <input type="date" class="form-control" id="fecha" name="fecha" required>
            </div>
            <div class="col-md-6">
              <label for="hora" class="form-label">Hora:</label>
              <input type="text" class="form-control" id="hora" name="hora" pattern="(0[1-9]|1[0-2]):[0-5][0-9] (AM|PM)" placeholder="hh:mm AM/PM" required>
            </div>
            <div class="col-12">
              <label for="descripcion" class="form-label">Descripción:</label>
              <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="col-12 mt-4">
              <button type="submit" class="btn btn-primary w-100">Crear evento</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>