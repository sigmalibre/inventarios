/**
 * Sincroniza los inputs del precio de venta, precio de venta + iva y utilidad
 * de un producto para que al escribir en uno, se actualize el valor en los demás.
 */

$(function () {
    'use strict';

    // Cachear los selectores de los inputs.
    var costo = $('#valorCostoActualTotal');
    var utilidad = $('#utilidadProducto');
    var precioVenta = $('#precioVentaProducto');
    var precioVentaIva = $('#precioVentaIVAProducto');

    /**
     * Obtiene todos los datos necesarios para realizar el cálculo de precio de venta sincronizado.
     *
     * @returns {{costo: number, utilidad: number, precioVenta: number, precioVentaIva: number, porcentajeIva: number}}
     */
    var getValoresPrecios = function () {
        return {
            costo: Number(costo.val()),
            utilidad: Number(utilidad.val()),
            precioVenta: Number(precioVenta.val()),
            precioVentaIva: Number(precioVentaIva.val()),
            porcentajeIva: Number(precioVentaIva.data('iva'))
        };
    };

    /**
     * Da formato a los números para que sean de cuatro decimales.
     *
     * @param {number} num
     * @returns {string}
     */
    var format_decimals = function (num) {
        return num.toFixed(4);
    };

    /**
     * Actualiza los campos cuando el input de la utilidad ha llegado a cero, ya que este no puede ser menor.
     *
     * @param data
     */
    var resetToZero = function (data) {
        utilidad.val(format_decimals(0));
        // Cuando la utilidad es cero, el precio de venta es igual al costo.
        precioVenta.val(format_decimals(data.costo));
        precioVentaIva.val(format_decimals(data.costo * (1 + data.porcentajeIva / 100)));
    };

    // Sincronizar cuando el input de utilidad sea cambiado
    utilidad.on('input', function () {
        var data = getValoresPrecios();

        if (data.utilidad < 0) {
            return false;
        }

        // El precio de venta de un producto es igual al costo más la utilidad.
        precioVenta.val(format_decimals(data.costo + data.utilidad));
        precioVentaIva.val(format_decimals((data.costo + data.utilidad) * (1 + data.porcentajeIva / 100)));
    });

    // Sincronizar cuando el input de precio de venta sea cambiado
    precioVenta.on('input', function () {
        var data = getValoresPrecios();

        var calculated_utilidad = data.precioVenta - data.costo;

        if (calculated_utilidad < 0) {
            resetToZero(data);

            return false;
        }

        utilidad.val(format_decimals(calculated_utilidad));
        precioVentaIva.val(format_decimals(data.precioVenta * (1 + data.porcentajeIva / 100)));
    });

    // Sincronizar cuando el input de precio venta + iva sea cambiado
    precioVentaIva.on('input', function () {
        var data = getValoresPrecios();

        var calculated_utilidad = data.precioVentaIva / (1 + data.porcentajeIva / 100) - data.costo;

        if (calculated_utilidad < 0) {
            resetToZero(data);

            return false;
        }

        utilidad.val(format_decimals(calculated_utilidad));
        precioVenta.val(format_decimals(data.precioVentaIva / (1 + data.porcentajeIva / 100)));
    });
});
