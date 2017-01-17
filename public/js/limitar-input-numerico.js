/**
 * Limita cualquier input a una cantidad determinada. Esto se debe a que el atributo MAX de los inputs no soporta
 * muy bien los números decimales.
 */

$(function () {
    'use strict';

    $('.limit-to-max-value').on('input', function (event) {
        var input = $(event.currentTarget);

        var valorMaximo = Number(input.data('max'));

        if (Number(input.val()) > valorMaximo) {
            input.val(valorMaximo);
        }
    });
});