<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
?>

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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver evento - CORHUILA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Geomanist:wght@400;700&display=swap" rel="stylesheet">
    <link href="styles/estilo_ver_eventos.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid custom-container">
            <a class="navbar-brand custom-logo" href="#">
                <img src="assets/CORHUILA.png" alt="Logo" width="80" height="60" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse custom-navbar" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="crear_eventos.php">Crear Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mostrar_eventos.php">Eventos</a>
                    </li>
                </ul>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" onclick="cerrarSesion()">Cerrar sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
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
                    <a href="Lista Eventos/eliminar_evento.php?id_evento=<?php echo $idEvento; ?>" class="btn btn-danger">Eliminar evento</a>
                </div>
            </div>
        </div>

        <?php
        require_once 'php/conexion.php';

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

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container-fluid custom-container">
            <h2 class="text-center">Corporación Universitaria del Huila</h2>
            <div class="row mt-4">
                <div class="col-md-2 col-sm-12 mb-3">
                    <img src="assets/CORHUILA.png" alt="Logo" class="footer-logo">
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <h5>Sobre Nosotros</h5>
                    <p>Institución de Educación Superior Sujeta a Inspección y Vigilancia por el Ministerio de Educación Nacional</p>
                </div>
                <div class="col-md-4 col-sm-6 mb-3">
                    <h5>Centros de Atención</h5>
                    <div class="row">
                        <div class="col-sm-6">
                            <ul class="list-unstyled">
                                <li>Neiva</li>
                                <li>Quirinal: Calle 21 No. 6 – 01</li>
                                <li>Prado Alto: Calle 8 No. 32 – 49</li>
                                <li>Huila, Colombia</li>
                                <li>Conmutador: (608)875 4220 –</li>
                                <li>(608)863 0969</li>
                            </ul>
                        </div>
                        <div class="col-sm-6">
                            <ul class="list-unstyled">
                                <li>Pitalito</li>
                                <li>Carrera 2 No. 1 – 27</li>
                                <li>Huila, Colombia</li>
                                <li>Teléfono: (608) 835 0459 – 322 872 9428</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 mb-3">
                    <h5>Contacto</h5>
                    <ul class="list-unstyled">
                        <li>Teléfono: (123) 456-7890</li>
                        <li>Email: info@corhuila.edu.co</li>
                        <li>Dirección: Calle Principal #123</li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row mt-3">
                <div class="col-md-6 col-sm-12 mb-2 text-center">
                    <p>&copy; 2024 CORHUILA. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 col-sm-12 mb-2 text-md-end text-center">
                    <p class="text-center">Diseñado por <span>AGCO2002</span></p>
                </div>
            </div>
            <div class="social-icons">
                <a href="https://www.instagram.com/corhuilaoficial/" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="https://www.facebook.com/UHCorhuila" class="social-icon"><i class="fab fa-facebook"></i></a>
                <a href="https://x.com/i/flow/login?redirect_after_login=%2Fcorhuila" class="social-icon"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>