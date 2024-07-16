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
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Aplicativo Corhuila</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
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
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="inicio.php">Sistema Aplicativo Web</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    
            <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Configuración</a></li>
                        
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="index.php">Salir</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Corhuila</div>
                            <a class="nav-link" href="inicio.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Inicio
                            </a>
                            <a class="nav-link" href="eventos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Eventos
                            </a>
                            <a class="nav-link" href="administrativos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Administrativos
                            </a>
                            <a class="nav-link" href="usuarios.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Usuarios
                            </a>
                            
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Eventos Registrados</h1>
                        
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
                        
                        
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
