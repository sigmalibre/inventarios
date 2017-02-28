/**
 * MANEJO DE VENTANAS MODALES DE ELIMINAR RECURSOS
 */

/**
 * CERRAR COLLAPSE DE OPCIONES AL CERRAR EL MODAL
 */
$(function () {
    $('body').on('hide.bs.modal', '.modal-eliminar-recurso', function (e) {
        var modal = $(e.currentTarget);

        modal.find('.collapse').collapse('hide');
    });
});

/**
 * MANDAR ALERTA DE FEEDBACK AL ELIMINAR PERMANENTEMENTE
 */
$(function () {
    eventos.on('eliminar-recurso-perma', function (data) {
        if (data.error || data.status == 'error') {
            eventos.emit('alert-feedback', {
                context: 'danger',
                icon: 'remove-sign',
                message: 'El item no pudo ser eliminado.'
            });
        }
        if (data.status == 'success') {
            $(':input').prop('disabled', true);
            $('tr').removeClass('anchorize');
            $('table').removeClass('table-hover').addClass('text-muted');
            eventos.emit('alert-feedback', {
                context: 'success',
                icon: 'ok',
                message: 'El item se eliminó correctamente.'
            });
        }
    });
});
