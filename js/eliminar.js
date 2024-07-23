function confirmarEliminacion(idEvento) {
    if (confirm('¿Estás seguro de que quieres eliminar este evento?')) {
        window.location.href = 'php/eliminar_evento.php?id_evento=' + idEvento + '&confirmar=1';
    }
}


function confirmarEliminarParticipante(idEvento, idParticipante) {
    if (confirm('¿Estás seguro de que deseas eliminar este participante?')) {
        // Hacer una solicitud AJAX para eliminar el participante
        fetch(`php/eliminar_participante.php?id_evento=${idEvento}&id_participante=${idParticipante}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('El participante se eliminó correctamente.');
                    window.location.href = `ver_evento.php?id_evento=${idEvento}`;
                } else {
                    alert('Hubo un error al eliminar el participante: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error al procesar la solicitud.');
            });
    }
}
