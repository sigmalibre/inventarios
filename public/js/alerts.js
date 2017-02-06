/**
 * Manejo de Alertas para el usuario
 */

$(function () {
    'use strict';

    var alertTemplate = $('#alert-template').html();
    var alertsGoHere = $('#alert-group');

    var renderAlerta = function (context, icon, message) {
        alertsGoHere.append(Mustache.to_html(alertTemplate, {
            context: context,
            icon: icon,
            message: message
        }));
    };

    eventos.on('alert-feedback', function (data) {
        renderAlerta(data.context, data.icon, data.message);
    });
});