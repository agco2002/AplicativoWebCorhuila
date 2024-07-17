// script_cabecera.js
document.addEventListener('DOMContentLoaded', function() {
    const logoutBtn = document.getElementById('logoutBtn');
    
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            fetch('php/logout.php', {
                method: 'POST',
                credentials: 'same-origin'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'login.php';
                } else {
                    alert('Error al cerrar sesión: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cerrar sesión');
            });
        });
    }
});