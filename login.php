<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="estilos.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Login Administrativo</h2>
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="loginCorreo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="loginCorreo" required>
                    </div>
                    <div class="mb-3">
                        <label for="loginContrasena" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="loginContrasena" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Iniciar Sesión</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/login.js"></script>
</body>
</html>