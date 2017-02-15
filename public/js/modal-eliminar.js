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