<?php
header('Content-Type: text/html; charset=utf-8');
// ... resto de tu código PHP ...
session_start();
require_once 'php/conexion.php';

// Verificar si el usuario está logueado y es administrativo
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['cargo'] !== 'Administrativo') {
    header('Location: login.php');
    exit();
}

// Paginación
$registros_por_pagina = 20;
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$inicio = ($pagina - 1) * $registros_por_pagina;

// Búsqueda
$busqueda = isset($_GET['busqueda']) ? $conn->real_escape_string($_GET['busqueda']) : '';
$where = '';
if ($busqueda) {
    $where = "WHERE admin_nombre LIKE '%$busqueda%' 
              OR tipo_accion LIKE '%$busqueda%' 
              OR usuario_afectado_nombre LIKE '%$busqueda%'
              OR usuario_afectado_identificacion LIKE '%$busqueda%'
              OR usuario_afectado_cargo LIKE '%$busqueda%'
              OR detalles LIKE '%$busqueda%'";
}

// Obtener registros de acciones
$sql = "SELECT * FROM registro_acciones $where ORDER BY fecha_hora_accion DESC LIMIT $inicio, $registros_por_pagina";
$result = $conn->query($sql);

if ($result === false) {
    die("Error en la consulta: " . $conn->error);
}

$registros = $result->fetch_all(MYSQLI_ASSOC);

// Obtener el total de registros para la paginación
$sql_total = "SELECT COUNT(*) as total FROM registro_acciones $where";
$result_total = $conn->query($sql_total);
$row_total = $result_total->fetch_assoc();
$total_registros = $row_total['total'];
$total_paginas = ceil($total_registros / $registros_por_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Acciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="estilos.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Registro de Acciones</h1>
        
        <!-- Formulario de búsqueda -->
        <form action="" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="busqueda" placeholder="Buscar..." value="<?php echo htmlspecialchars($busqueda); ?>">
                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
            </div>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Admin</th>
                    <th>Acción</th>
                    <th>Fecha y Hora de Acción</th>
                    <th>Fecha y Hora de Ingreso</th>
                    <th>Usuario Afectado</th>
                    <th>Detalles</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($registros as $registro): ?>
                <tr>
                    <td><?php echo htmlspecialchars($registro['admin_nombre']); ?></td>
                    <td><?php echo htmlspecialchars($registro['tipo_accion']); ?></td>
                    <td><?php echo htmlspecialchars($registro['fecha_hora_accion']); ?></td>
                    <td><?php echo htmlspecialchars($registro['fecha_hora_ingreso']); ?></td>
                    <td>
                        <?php 
                        if ($registro['usuario_afectado_nombre']) {
                            echo htmlspecialchars($registro['usuario_afectado_nombre']) . " (" . 
                                 htmlspecialchars($registro['usuario_afectado_identificacion']) . ") - " . 
                                 htmlspecialchars($registro['usuario_afectado_cargo']);
                        } else {
                            echo "N/A";
                        }
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($registro['detalles']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Paginación -->
        <nav>
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <li class="page-item <?php echo ($pagina == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="?pagina=<?php echo $i; ?>&busqueda=<?php echo urlencode($busqueda); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>

        <a href="index.php" class="btn btn-primary">Volver al inicio</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>