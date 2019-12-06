function sendCotizacion(idx) {
    if (!datos_cotizaciones[idx]) {
        return
    }
    var message = {
        detalles: datos_cotizaciones[idx].Datos,
        dontsave: true,
    }
    submitMethod.download('/cotizacion/nuevo', 'post', message, 'cotizacion-downloaded');
}

function eliminarCotizacion(id) {
	if (confirm('Estás seguro que deseas eliminar la cotización?')) {
		submitMethod.send('/cotizacion/' + id, 'delete', null, 'cotizacion-eliminada');
	}
}

eventos.on('cotizacion-eliminada', function (datos) {
    if (datos.status == "error") {
        eventos.emit('alert-feedback', {
            context: 'danger',
            icon: 'remove-sign',
            message: 'No se pudo eliminar la cotizacion.'
        });
        return false;
    }
    if (datos.status == "success") {
        eventos.emit('alert-feedback', {
            context: 'success',
            icon: 'ok',
            message: 'Se eliminó la cotizacion exitosamente!'
        });
        $('#linea-cotizacion-' + datos.id).remove()
    }
});