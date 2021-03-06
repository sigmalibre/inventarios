/**
 * Permite hacer submit de un formulario con otros métodos a parte de POST y GET.
 *
 * EJEMPLO DE USO:
 * <button class="submit-form-with-method"
 *      data-action="/producto/id/1"
 *      data-method="delete"
 *      data-triggerevent="producto-eliminado"
 *      data-targetform="">
 * </button>
 *
 * En los datos de action y method se pone lo que pondrías en los atributos de un formulario.
 *
 * En triggerevent se pone el evento que se disparará del módulo pubsub (ver pubsub.js).
 *
 * En targetform va el selector del formulario que se desea hacer submit. Si no se deja vacío,
 * siempre se envía el request con el método establecido a la URL establecida, pero sin datos.
 */

var submitMethod = (function () {
    
    var send = function (ulr, method, data, eventOnFinish) {
        $.ajax({
            url: ulr,
            method: method.toUpperCase(),
            data: data,
            dataType: 'json'
        }).done(function (response) {
            eventos.emit(eventOnFinish, response);
        }).fail(function (_, status, error) {
            eventos.emit(eventOnFinish, {
                error: {
                    status: status,
                    error: error
                }
            });
        });
    };

    var download = function (url, method, data, eventOnFinish) {
        // Jquery no soporta resposeType arraybuffer

        var xhr = new XMLHttpRequest();

        xhr.open(method.toUpperCase(), url, true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.responseType = 'arraybuffer';

        xhr.onload = function () {
            if (xhr.status !== 200) {
                eventos.emit(eventOnFinish, {
                    error: {
                        status: xhr.status,
                        error: 'Servidor no responde.'
                    }
                });

                return false;
            }

            var blob = new Blob([xhr.response], {type: xhr.getResponseHeader('Content-Type')});
            window.open(URL.createObjectURL(blob));

            eventos.emit(eventOnFinish, {
                status: 'success'
            });
        };

        xhr.onerror = function () {
            eventos.emit(eventOnFinish, {
                error: {
                    status: 'Network Failure',
                    error: 'No hay conexión al servidor.'
                }
            });
        };

        xhr.send(JSON.stringify(data));
    };

    return {
        send: send,
        download: download
    }
}());

$(function () {
    'use strict';

    $('.submit-form-with-method').on('click', function (event) {
        var target = $(event.currentTarget);
        var targetForm = $(target.data('targetform'));
        var serializedForm = '';

        if (targetForm.length) {
            serializedForm = targetForm.serialize();
        }

        submitMethod.send(target.data('action'), target.data('method'), serializedForm, target.data('triggerevent'));

        event.preventDefault();
    });
});