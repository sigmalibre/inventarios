/**
 * Desencadena un evento al dar click sobre un elemento con esta clase.
 */

$(function () {
    'use strict';

    $('body').on('click', '.trigger-event', function (event) {
        var target = $(event.currentTarget);
        if (window.getSelection().toString().length === 0) {
            eventos.emit(target.data('event'), target.data());
        }
    });

});