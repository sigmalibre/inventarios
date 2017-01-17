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

$(function () {
    'use strict';

    $('.submit-form-with-method').on('click', function (event) {
        var target = $(event.currentTarget);
        var targetForm = $(target.data('targetform'));
        var serializedForm = '';

        if (targetForm.length) {
            serializedForm = targetForm.serialize();
        }

        $.ajax({
            url: target.data('action'),
            method: target.data('method').toUpperCase(),
            data: serializedForm,
            dataType: 'json'
        }).done(function (data) {
            eventos.emit(target.data('triggerevent'), data);
        }).fail(function (_, status, error) {
            eventos.emit(target.data('triggerevent'), {
                error: {
                    status: status,
                    error: error
                }
            });
            console.log('[AJAX] ' + status + ': ' + error);
        });

        event.preventDefault();
    });
});