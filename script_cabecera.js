document.addEventListener('DOMContentLoaded', function() {
    const logoutBtn = document.getElementById('logoutBtn');
    
    logoutBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        fetch('logout.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = 'login.html';
                } else {
                    alert('Error al cerrar sesión');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al cerrar sesión');
            });
    });
});