// script.js
document.addEventListener('DOMContentLoaded', function() {
    const registroForm = document.getElementById('registroForm');
    const edicionForm = document.getElementById('edicionForm');
    const buscador = document.getElementById('buscador');
    const cargoSelect = document.getElementById('cargo');

    if (registroForm) registroForm.addEventListener('submit', handleRegistro);
    if (edicionForm) edicionForm.addEventListener('submit', handleEdicion);
    if (buscador) buscador.addEventListener('input', buscarUsuarios);
    if (cargoSelect) cargoSelect.addEventListener('change', toggleContrasenaField);

    function toggleContrasenaField() {
        const contrasenaDiv = document.getElementById('contrasenaDiv');
        if (contrasenaDiv) {
            contrasenaDiv.style.display = this.value === 'Administrativo' ? 'block' : 'none';
        }
    }
});

function handleRegistro(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    formData.append('accion', 'registrar');
    enviarSolicitud(formData, 'Usuario registrado con éxito', 'Error al registrar usuario');
}

function handleEdicion(e) {
    e.preventDefault();
    const formData = new FormData(e.target);
    formData.append('accion', 'editar');
    enviarSolicitud(formData, 'Usuario actualizado con éxito', 'Error al actualizar usuario');
}

function enviarSolicitud(formData, successMsg, errorMsg) {
    fetch('php/funciones.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.text(); // Cambiamos a text() en lugar de json()
    })
    .then(text => {
        console.log("Respuesta del servidor:", text); // Log de la respuesta completa
        try {
            const data = JSON.parse(text);
            if (data.success) {
                alert(successMsg);
                location.reload();
            } else {
                alert(errorMsg + ': ' + (data.error || 'Desconocido'));
            }
        } catch (e) {
            console.error("Error al parsear JSON:", e);
            alert("Error en la respuesta del servidor. Ver consola para más detalles.");
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(errorMsg + ': ' + error);
    });
}

function editarUsuario(id) {
    const formData = new FormData();
    formData.append('accion', 'obtenerUsuario');
    formData.append('id', id);

    fetch('php/funciones.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(usuario => {
        console.log('Datos del usuario:', usuario);
        document.getElementById('editId').value = usuario.id;
        document.getElementById('editNombre').value = usuario.nombre;
        document.getElementById('editEdad').value = usuario.edad;
        document.getElementById('editIdentificacion').value = usuario.identificacion;
        document.getElementById('editTelefono').value = usuario.telefono;
        document.getElementById('editSexo').value = usuario.sexo;
        document.getElementById('editCargo').value = usuario.cargo;
        document.getElementById('editUbicacion').value = usuario.ubicacion || ''; // Añade esta línea
        document.getElementById('editCorreo').value = usuario.correo;
        document.getElementById('editFechaIngreso').value = usuario.fecha_ingreso;
        document.getElementById('editHoraIngreso').value = usuario.hora_ingreso;
        document.getElementById('editFechaSalida').value = usuario.fecha_salida;
        document.getElementById('editHoraSalida').value = usuario.hora_salida;

        new bootstrap.Modal(document.getElementById('edicionModal')).show();
    });
}

function eliminarUsuario(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
        const formData = new FormData();
        formData.append('accion', 'eliminar');
        formData.append('id', id);
        enviarSolicitud(formData, 'Usuario eliminado con éxito', 'Error al eliminar usuario');
    }
}

function editarUsuario(id) {
    const formData = new FormData();
    formData.append('accion', 'obtenerUsuario');
    formData.append('id', id);

    fetch('php/funciones.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(usuario => {
        document.getElementById('editId').value = usuario.id;
        document.getElementById('editNombre').value = usuario.nombre;
        document.getElementById('editEdad').value = usuario.edad;
        document.getElementById('editIdentificacion').value = usuario.identificacion;
        document.getElementById('editTelefono').value = usuario.telefono;
        document.getElementById('editSexo').value = usuario.sexo;
        document.getElementById('editCargo').value = usuario.cargo;
        document.getElementById('editUbicacion').value = usuario.ubicacion; // Añade esta línea
        document.getElementById('editCorreo').value = usuario.correo;
        document.getElementById('editFechaIngreso').value = usuario.fecha_ingreso;
        document.getElementById('editHoraIngreso').value = usuario.hora_ingreso;
        document.getElementById('editFechaSalida').value = usuario.fecha_salida;
        document.getElementById('editHoraSalida').value = usuario.hora_salida;

        new bootstrap.Modal(document.getElementById('edicionModal')).show();
    });
}

function verDetalles(id) {
    const formData = new FormData();
    formData.append('accion', 'obtenerUsuario');
    formData.append('id', id);

    fetch('php/funciones.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(usuario => {
        console.log('Detalles del usuario:', usuario);
        const detallesHTML = `
            <p><strong>Nombre:</strong> ${usuario.nombre}</p>
            <p><strong>Edad:</strong> ${usuario.edad}</p>
            <p><strong>Identificación:</strong> ${usuario.identificacion}</p>
            <p><strong>Teléfono:</strong> ${usuario.telefono}</p>
            <p><strong>Sexo:</strong> ${usuario.sexo}</p>
            <p><strong>Cargo:</strong> ${usuario.cargo}</p>
            <p><strong>Ubicación:</strong> ${usuario.ubicacion || 'No especificada'}</p> 
            <p><strong>Correo:</strong> ${usuario.correo}</p>
            <p><strong>Fecha de Ingreso:</strong> ${usuario.fecha_ingreso}</p>
            <p><strong>Hora de Ingreso:</strong> ${formatTime(usuario.hora_ingreso)}</p>
            <p><strong>Fecha de Salida:</strong> ${usuario.fecha_salida || 'No registrada'}</p>
            <p><strong>Hora de Salida:</strong> ${usuario.hora_salida ? formatTime(usuario.hora_salida) : 'No registrada'}</p>
        `;
        document.getElementById('detallesUsuario').innerHTML = detallesHTML;
        new bootstrap.Modal(document.getElementById('detallesModal')).show();
    });
}

function formatTime(time) {
    return new Date('1970-01-01T' + time).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
}

function buscarUsuarios() {
    const busqueda = document.getElementById('buscador').value.toLowerCase();
    const filas = document.querySelectorAll('#tablaUsuarios tr');

    filas.forEach(fila => {
        const contenido = Array.from(fila.cells).slice(0, 4).map(cell => cell.textContent.toLowerCase()).join(' ');
        fila.style.display = contenido.includes(busqueda) ? '' : 'none';
    });
}

function cerrarSesion() {
    fetch('php/cerrar_sesion.php')
    .then(() => {
        window.location.href = 'login.php';
    });
}

