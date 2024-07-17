<!--index.php-->
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}
require_once 'php/funciones.php';
$usuarios = obtenerUsuarios();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Geomanist:wght@400;700&display=swap" rel="stylesheet">
    <link href="estilos.css" rel="stylesheet">
    <link href="estilo_cabecera.css" rel="stylesheet">
    <link href="estilo_footer.css" rel="stylesheet">

</head>
<body>
    
    <?php include 'cabecera.php'; ?>

    <div class="container mt-5">
        <h3 class="mb-4 text-center">Gestión de Usuarios</h3>
        <button class=" mb-3 boton " data-bs-toggle="modal" data-bs-target="#registroModal">Registrar Usuario</button>
        <input type="text" id="buscador" class="form-control mb-5" placeholder="Buscar usuarios..." style="border-color:  #28a745;">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Identificación</th>
                    <th>Cargo</th>
                    <th>Fecha de Ingreso</th>
                    <th>Hora de Ingreso</th>
                    <th>Fecha de Salida</th>
                    <th>Hora de Salida</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <?php
require_once 'php/funciones.php';
$usuarios = obtenerUsuarios();
?>

  
    <tbody id="tablaUsuarios">
        <?php if ($usuarios): ?>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?php echo $usuario['nombre']; ?></td>
                    <td><?php echo $usuario['identificacion']; ?></td>
                    <td><?php echo $usuario['cargo']; ?></td>
                    <td><?php echo $usuario['fecha_ingreso']; ?></td>
                    <td><?php echo date('h:i A', strtotime($usuario['hora_ingreso'])); ?></td>
                    <td><?php echo $usuario['fecha_salida']; ?></td>
                    <td><?php echo date('h:i A', strtotime($usuario['hora_salida'])); ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editarUsuario(<?php echo $usuario['id']; ?>)">Editar</button>
                        <button class="btn btn-sm btn-danger" onclick="eliminarUsuario(<?php echo $usuario['id']; ?>)">Eliminar</button>
                        <button class="btn btn-sm btn-info" onclick="verDetalles(<?php echo $usuario['id']; ?>)">Detalles</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No hay usuarios registrados.</td>
            </tr>
        <?php endif; ?>
    </tbody>
        </table>
    </div>

    <!-- Modal de Registro -->
    <div class="modal fade" id="registroModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registroForm">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="edad" class="form-label">Edad</label>
                            <input type="number" class="form-control" id="edad" name="edad" required>
                        </div>
                        <div class="mb-3">
                            <label for="identificacion" class="form-label">Identificación</label>
                            <input type="text" class="form-control" id="identificacion" name="identificacion" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="sexo" class="form-label">Sexo</label>
                            <select class="form-select" id="sexo" name="sexo" required>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="cargo" class="form-label">Cargo</label>
                            <select class="form-select" id="cargo" name="cargo" required>
                                <option value="Estudiante">Estudiante</option>
                                <option value="Profesor">Profesor</option>
                                <option value="Externo">Externo</option>
                                <option value="Administrativo">Administrativo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                        </div>
                        <div class="mb-3">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo" required>
                        </div>
                        <div class="date-time-inputs">
                            <div class="mb-3">
                                <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
                            </div>
                            <div class="mb-3">
                                <label for="hora_ingreso" class="form-label">Hora de Ingreso</label>
                                <input type="time" class="form-control" id="hora_ingreso" name="hora_ingreso" required>
                            </div>
                        </div>
                        <div class="date-time-inputs">
                            <div class="mb-3">
                                <label for="fecha_salida" class="form-label">Fecha de Salida</label>
                                <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" required>
                            </div>
                            <div class="mb-3">
                                <label for="hora_salida" class="form-label">Hora de Salida</label>
                                <input type="time" class="form-control" id="hora_salida" name="hora_salida" required>
                            </div>
                        </div>
                        <div class="mb-3" id="contrasenaDiv" style="display: none;">
                            <label for="contrasena" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena">
                        </div>
                        <button type="submit" class="btn btn-success">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Edición -->
    <div class="modal fade" id="edicionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="edicionForm">
                        <input type="hidden" id="editId" name="id">
                        <div class="mb-3">
                            <label for="editNombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="editNombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEdad" class="form-label">Edad</label>
                            <input type="number" class="form-control" id="editEdad" name="edad" required>
                        </div>
                        <div class="mb-3">
                            <label for="editIdentificacion" class="form-label">Identificación</label>
                            <input type="text" class="form-control" id="editIdentificacion" name="identificacion" required>
                        </div>
                        <div class="mb-3">
                            <label for="editTelefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="editTelefono" name="telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSexo" class="form-label">Sexo</label>
                            <select class="form-select" id="editSexo" name="sexo" required>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editCargo" class="form-label">Cargo</label>
                            <select class="form-select" id="editCargo" name="cargo" required>
                                <option value="Estudiante">Estudiante</option>
                                <option value="Profesor">Profesor</option>
                                <option value="Externo">Externo</option>
                                <option value="Administrativo">Administrativo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editUbicacion" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="editUbicacion" name="ubicacion" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCorreo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="editCorreo" name="correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="editFechaIngreso" class="form-label">Fecha de Ingreso</label>
                            <input type="date" class="form-control" id="editFechaIngreso" name="fecha_ingreso" required>
                        </div>
                        <div class="mb-3">
                            <label for="editHoraIngreso" class="form-label">Hora de Ingreso</label>
                            <input type="time" class="form-control" id="editHoraIngreso" name="hora_ingreso" required>
                        </div>
                        <div class="mb-3">
                            <label for="editFechaSalida" class="form-label">Fecha de Salida</label>
                            <input type="date" class="form-control" id="editFechaSalida" name="fecha_salida" required>
                        </div>
                        <div class="mb-3">
                            <label for="editHoraSalida" class="form-label">Hora de Salida</label>
                            <input type="time" class="form-control" id="editHoraSalida" name="hora_salida" required>
                        </div>
                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

   <!-- Modal de Detalles -->
<div class="modal fade" id="detallesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detallesUsuario">
                <!-- Los detalles del usuario se insertarán aquí dinámicamente -->
            </div>
        </div>
    </div>
</div>
<br><br>
<?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script src="script_cabecera.js"></script>
</body>
</html>