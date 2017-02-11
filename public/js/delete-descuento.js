/**
 * Maneja la respuesta al eliminar un descuento.
 */

$(function () {
    'use strict';

    eventos.on('descuento-eliminar-perma', function (data) {
        if (data.error || data.status === 'error') {
            eventos.emit('alert-feedback', {
                context: 'danger',
                icon: 'remove-sign',
                message: 'No se pudo eliminar el descuento.'
            });
        }
        if (data.status === 'success') {
            eventos.emit('alert-feedback', {
                context: 'success',
                icon: 'ok-sign',
                message: 'Se eliminó el descuento con éxito.'
            });
            $('#panelDescuentos *').filter(':input').prop('disabled', true);
        }
    });
});