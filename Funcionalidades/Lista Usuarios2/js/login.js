//login.js
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData();
    formData.append('accion', 'login');
    formData.append('correo', document.getElementById('loginCorreo').value);
    formData.append('contrasena', document.getElementById('loginContrasena').value);

    fetch('php/funciones.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'index.php';
        } else {
            alert('Credenciales incorrectas');
        }
    });
});