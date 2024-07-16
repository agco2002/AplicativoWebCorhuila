<?php
require_once 'conexion.php';

function ejecutarConsulta($sql, $params, $types) {
    global $conn;
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        error_log("Error en la preparación de la consulta: " . $conn->error);
        return false;
    }
    $stmt->bind_param($types, ...$params);
    $result = $stmt->execute();
    if ($result === false) {
        error_log("Error en la ejecución de la consulta: " . $stmt->error);
        return false;
    }
    return $result ? ($stmt->insert_id ?: true) : false;
}

function registrarUsuario($nombre, $edad, $identificacion, $telefono, $sexo, $cargo, $ubicacion, $correo, $fecha_ingreso, $hora_ingreso, $fecha_salida, $hora_salida, $contrasena = null) {
    $contrasena_hash = $contrasena ? password_hash($contrasena, PASSWORD_DEFAULT) : null;
    $sql = "INSERT INTO usuarios (nombre, edad, identificacion, telefono, sexo, cargo, ubicacion, correo, fecha_ingreso, hora_ingreso, fecha_salida, hora_salida, contrasena) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    return ejecutarConsulta($sql, [$nombre, $edad, $identificacion, $telefono, $sexo, $cargo, $ubicacion, $correo, $fecha_ingreso, $hora_ingreso, $fecha_salida, $hora_salida, $contrasena_hash], "sisssssssssss");
}

function obtenerUsuarios() {
    global $conn;
    $sql = "SELECT * FROM usuarios";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function editarUsuario($id, $nombre, $edad, $identificacion, $telefono, $sexo, $cargo, $ubicacion, $correo, $fecha_ingreso, $hora_ingreso, $fecha_salida, $hora_salida) {
    $sql = "UPDATE usuarios SET nombre=?, edad=?, identificacion=?, telefono=?, sexo=?, cargo=?, ubicacion=?, correo=?, fecha_ingreso=?, hora_ingreso=?, fecha_salida=?, hora_salida=? WHERE id=?";
    return ejecutarConsulta($sql, [$nombre, $edad, $identificacion, $telefono, $sexo, $cargo, $ubicacion, $correo, $fecha_ingreso, $hora_ingreso, $fecha_salida, $hora_salida, $id], "sisssssssssss");
}

function eliminarUsuario($id) {
    $sql = "DELETE FROM usuarios WHERE id=?";
    return ejecutarConsulta($sql, [$id], "i");
}

function obtenerUsuarioPorId($id) {
    global $conn;
    $sql = "SELECT * FROM usuarios WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
    
    error_log("Usuario obtenido: " . json_encode($usuario));
    
    return $usuario;
}

function loginAdministrativo($correo, $contrasena) {
    global $conn;
    $sql = "SELECT * FROM usuarios WHERE correo = ? AND cargo = 'Administrativo'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($usuario = $result->fetch_assoc()) {
        if (password_verify($contrasena, $usuario['contrasena'])) {
            return $usuario;
        }
    }
    return false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = $_POST['accion'];
    $response = ['success' => false, 'error' => ''];

    try {
        switch ($accion) {
            case 'registrar':
                $result = registrarUsuario(
                    $_POST['nombre'],
                    $_POST['edad'],
                    $_POST['identificacion'],
                    $_POST['telefono'],
                    $_POST['sexo'],
                    $_POST['cargo'],
                    $_POST['ubicacion'],
                    $_POST['correo'],
                    $_POST['fecha_ingreso'],
                    $_POST['hora_ingreso'],
                    $_POST['fecha_salida'],
                    $_POST['hora_salida'],
                    $_POST['contrasena'] ?? null
                );
                if ($result === false) {
                    throw new Exception("Error al registrar usuario");
                }
                $response['success'] = true;
                break;
            case 'editar':
                $response['success'] = editarUsuario($_POST['id'], $_POST['nombre'], $_POST['edad'], $_POST['identificacion'], $_POST['telefono'], $_POST['sexo'], $_POST['cargo'], $_POST['ubicacion'], $_POST['correo'], $_POST['fecha_ingreso'], $_POST['hora_ingreso'], $_POST['fecha_salida'], $_POST['hora_salida']);
                break;
            case 'eliminar':
                $response['success'] = eliminarUsuario($_POST['id']);
                break;
            case 'obtenerUsuario':
                $response = obtenerUsuarioPorId($_POST['id']);
                break;
            case 'login':
                $usuario = loginAdministrativo($_POST['correo'], $_POST['contrasena']);
                if ($usuario) {
                    session_start();
                    $_SESSION['usuario'] = $usuario;
                    $response['success'] = true;
                }
                break;
            default:
                throw new Exception("Acción no reconocida");
        }
    } catch (Exception $e) {
        $response['error'] = $e->getMessage();
        error_log("Error en la acción $accion: " . $e->getMessage());
    }

    echo json_encode($response);
}
?>