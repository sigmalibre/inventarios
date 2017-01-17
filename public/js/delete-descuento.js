/**
 * Maneja la respuesta al eliminar un descuento.
 */

$(function () {
    'use strict';

    var alertTemplate = $('#alert-template').html();
    var alertsGoHere = $('#alert-group');

    var renderizarTemplate = function (context, icon, message) {
        alertsGoHere.append(Mustache.to_html(alertTemplate, {
            context: context,
            icon: icon,
            message: message
        }));
    };

    eventos.on('descuento-eliminar-perma', function (data) {
        if (data.error || data.status === 'error') {
            renderizarTemplate('danger', 'remove-sign', 'No se pudo eliminar el descuento.');
        }
        if (data.status === 'success') {
            renderizarTemplate('success', 'ok-sign', 'Se eliminó el descuento con éxito.');
            $('#panelDescuentos *').filter(':input').prop('disabled', true);
        }
    });
});