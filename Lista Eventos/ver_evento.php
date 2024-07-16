<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver evento</title>
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
        <?php
        // Obtener ID del evento
        $idEvento = $_GET['id_evento'];

        // Conectarse a la base de datos
        $db = new mysqli('localhost', 'root', '', 'corhuila');

        // Consultar datos del evento
        $consulta = "SELECT titulo, iniciador, cargo, descripcion, fecha, hora, ubicacion FROM eventos WHERE id_evento = ?";
        $stmt = $db->prepare($consulta);
        $stmt->bind_param('i', $idEvento);
        $stmt->execute();
        $stmt->bind_result($tituloEvento, $iniciadorEvento, $cargoEvento, $descripcionEvento, $fechaEvento, $hora_24, $ubicacionEvento);
        $stmt->fetch();
        $stmt->close();

        // Convertir hora de 24 horas a formato AM/PM
        $hora_ampm = date("h:i A", strtotime($hora_24));
        ?>

        <div class="card mb-4">
            <div class="card-body">
                <h1 class="card-title text-success"><?php echo htmlspecialchars($tituloEvento); ?></h1>
                <h2 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($iniciadorEvento); ?> - <?php echo htmlspecialchars($cargoEvento); ?></h2>
                <p class="card-text"><?php echo htmlspecialchars($descripcionEvento); ?></p>
                <p class="card-text"><strong>Fecha:</strong> <?php echo htmlspecialchars($fechaEvento); ?> - <strong>Hora:</strong> <?php echo htmlspecialchars($hora_ampm); ?></p>
                <p class="card-text"><strong>Ubicación:</strong> <?php echo htmlspecialchars($ubicacionEvento); ?></p>
                
                <div class="d-flex justify-content-between mt-4">
                    <a href="agregar_participantes.php?id_evento=<?php echo $idEvento; ?>" class="btn btn-custom">Agregar participantes</a>
                    <a href="generar_pdf.php?id_evento=<?php echo $idEvento; ?>" class="btn btn-custom">Descargar PDF</a>
                    <a href="editar_evento.php?id_evento=<?php echo $idEvento; ?>" class="btn btn-warning">Editar evento</a>
                    <a href="eliminar_evento.php?id_evento=<?php echo $idEvento; ?>" class="btn btn-danger">Eliminar evento</a>
                </div>
            </div>
        </div>

        <?php
        require_once 'conexion.php';

        if ($idEvento) {
            $sql = "SELECT id_participante, nombre, identificación, correo FROM participantes WHERE id_evento = ?";
            $stmtParticipantes = $conn->prepare($sql);
            $stmtParticipantes->bind_param("i", $idEvento);
            $stmtParticipantes->execute();
            $result = $stmtParticipantes->get_result();

            if ($result->num_rows > 0) {
                echo "<h3 class='text-success mb-3'>Participantes actuales:</h3>";
                echo "<div class='table-responsive'>";
                echo "<table class='table table-hover'>";
                echo "<thead class='table-success'><tr><th>Nombre</th><th>Identificación</th><th>Correo</th><th>Acciones</th></tr></thead>";
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['identificación']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['correo']) . "</td>";
                    echo "<td>
                        <a href='editar_participante.php?id_evento=$idEvento&id_participante={$row['id_participante']}' class='btn btn-sm btn-warning me-2'>Editar</a>
                        <a href='eliminar_participante.php?id_evento=$idEvento&id_participante={$row['id_participante']}' class='btn btn-sm btn-danger'>Eliminar</a>
                    </td>";
                    echo "</tr>";
                }
                echo "</tbody></table>";
                echo "</div>";
            } else {
                echo "<p class='alert alert-info'>No hay participantes registrados para este evento.</p>";
            }
        } else {
            echo "<p class='alert alert-danger'>No se especificó un ID de evento válido.</p>";
        }

        $stmtParticipantes->close();
        $db->close();
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>