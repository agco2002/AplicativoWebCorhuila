<?php
// Conectarse a la base de datos
$db = new mysqli('localhost', 'root', '', 'corhuila');

// Recuperar la lista de eventos
$consultaEventos = "SELECT id_evento, titulo, iniciador, cargo, fecha, hora, ubicacion FROM eventos ORDER BY fecha, hora";
$stmtEventos = $db->prepare($consultaEventos);
$stmtEventos->execute();
$stmtEventos->bind_result($idEvento, $tituloEvento, $iniciadorEvento, $cargoEvento, $fechaEvento, $hora_24, $ubicacionEvento);

// Almacenar los eventos en un array
$eventos = [];
while ($stmtEventos->fetch()) {
    $eventos[] = [
        'id' => $idEvento,
        'titulo' => $tituloEvento,
        'iniciador' => $iniciadorEvento,
        'cargo' => $cargoEvento,
        'fecha' => $fechaEvento,
        'hora' => date("h:i A", strtotime($hora_24)),
        'ubicacion' => $ubicacionEvento
    ];
}

$stmtEventos->close();
$db->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }
        .card-title a {
            color: #28a745;
            text-decoration: none;
            font-weight: bold;
        }
        .card-title a:hover {
            text-decoration: underline;
        }
        .btn-custom {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
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
    <div class="container mt-5">
        <h1 class="text-center mb-5 text-success">Eventos</h1>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php foreach ($eventos as $evento): ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">
                                <a href="ver_evento.php?id_evento=<?php echo $evento['id']; ?>">
                                    <?php echo htmlspecialchars($evento['titulo']); ?>
                                </a>
                            </h5>
                            <p class="card-text">
                                <strong>Iniciador:</strong> <?php echo htmlspecialchars($evento['iniciador']); ?><br>
                                <strong>Cargo:</strong> <?php echo htmlspecialchars($evento['cargo']); ?><br>
                                <strong>Fecha:</strong> <?php echo htmlspecialchars($evento['fecha']); ?><br>
                                <strong>Hora:</strong> <?php echo htmlspecialchars($evento['hora']); ?><br>
                                <strong>Ubicación:</strong> <?php echo htmlspecialchars($evento['ubicacion']); ?>
                            </p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="ver_evento.php?id_evento=<?php echo $evento['id']; ?>" class="btn btn-custom btn-sm w-100">Ver detalles</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>