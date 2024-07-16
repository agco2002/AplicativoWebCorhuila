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
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Sistema Aplicativo Web</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
    
            <ul class="navbar-nav ms-auto me-0 me-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">Configuración</a></li>
                        
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Salir</a></li>
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
                            <a class="nav-link" href="Eventos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Eventos
                            </a>
                            <a class="nav-link" href="administrativos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Administrativos
                            </a>
                            <a class="nav-link" href="Usuarios.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Usuarios
                            </a>
                            
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Registrar Evento</h1>
                        <hr>
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
