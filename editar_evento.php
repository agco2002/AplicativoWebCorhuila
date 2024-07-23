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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Geomanist:wght@400;700&display=swap" rel="stylesheet">
    <link href="styles/estilo_editar_eventos.css" rel="stylesheet">
</head>
<body>
    <!-- Cabecera -->
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

    <!-- Contenido principal -->
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center mb-5 text-success">Editar evento</h1>
                <form action="Lista Eventos/actualizar_evento.php" method="post">
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
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-success w-100">Actualizar evento</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5">
        <div class="container-fluid custom-container">
            <h1 class="text-center">Corporación Universitaria del Huila</h1>
            <br>
            <div class="row">
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
                        <li>Email: info@tuempresa.com</li>
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