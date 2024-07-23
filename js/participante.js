document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        
        fetch('./php/guardar_participantes.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showAlert(data.message, 'success', data.redirect);
            } else {
                showAlert(data.message, 'error');
            }
        })
        .catch(error => {
            showAlert('Error en el sistema', 'error');
        });
    });
});

function showAlert(message, type, redirect = null) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    alertDiv.setAttribute('role', 'alert');
    
    alertDiv.innerHTML = `
        ${message}
        ${redirect ? `<br><a href="${redirect}" class="alert-link">Ver evento</a>` : ''}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.querySelector('.card-body').insertBefore(alertDiv, document.querySelector('form'));
    
    const alertInstance = new bootstrap.Alert(alertDiv);
    
    if (redirect) {
        setTimeout(() => {
            window.location.href = redirect;
        }, 3000);
    }
}