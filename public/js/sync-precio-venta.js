/**
 * Sincroniza los inputs del precio de venta, precio de venta + iva y utilidad
 * de un producto para que al escribir en uno, se actualize el valor en los demás.
 */

$(function () {
    'use strict';

    // Cachear los selectores de los inputs.
    var inputCosto = $('#valorCostoActualTotal');
    var utilidad = $('#utilidadProducto');
    var utilidadIva = $('#utilidadProductoConIVA');
    var precioVenta = $('#precioVentaProducto');
    var precioVentaIva = $('#precioVentaIVAProducto');
    var porcentajeGanancia = $('#porcentajeGanancia');

    var costo = Number(inputCosto.val());
    var iva = 1 + Number(precioVentaIva.data('iva')) / 100

    /**
     * Obtiene todos los datos necesarios para realizar el cálculo de precio de venta sincronizado.
     *
     * @returns {{costo: number, utilidad: number, precioVenta: number, precioVentaIva: number, porcentajeIva: number}}
     */
    var getValoresPrecios = function () {
        return {
            costo: costo,
            costoConIva: costo * iva,
            utilidad: Number(utilidad.val()),
            utilidadIva: Number(utilidadIva.val()),
            precioVenta: Number(precioVenta.val()),
            precioVentaIva: Number(precioVentaIva.val()),
            porcentajeIva: Number(precioVentaIva.data('iva')),
            porcentajeGanancia: Number(porcentajeGanancia.val()),
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

    // Es requisito que el costo sea mostrado con IVA, para poder saber el precio al que fue comprado.
    inputCosto.val(format_decimals(costo * iva));

    /**
     * Actualiza los campos cuando el input de la utilidad ha llegado a cero, ya que este no puede ser menor.
     *
     * @param data
     */
    var resetToZero = function (data) {
        utilidad.val(format_decimals(0));
        utilidadIva.val(format_decimals(0));
        porcentajeGanancia.val((0).toFixed(2))
        // Cuando la utilidad es cero, el precio de venta es igual al costo.
        precioVenta.val(format_decimals(data.costo));
        precioVentaIva.val(format_decimals(data.costo * iva));
    };

    var updatePorcentajeGanancia = function () {
        var data = getValoresPrecios()
        var valor = ((data.precioVentaIva / data.costoConIva) - 1) * 100
        if (isNaN(valor) || !isFinite(valor) || !valor) {
            valor = 0
        }
        porcentajeGanancia.val(valor.toFixed(2))
    }

    // Sincronizar cuando el input de utilidad sea cambiado
    utilidad.on('change', function () {
        var data = getValoresPrecios();

        if (data.utilidad < 0) {
            return false;
        }

        // El precio de venta de un producto es igual al costo más la utilidad.
        precioVenta.val(format_decimals(data.costo + data.utilidad));
        utilidadIva.val(format_decimals(data.utilidad * (1 + data.porcentajeIva / 100)));
        precioVentaIva.val(format_decimals((data.costo + data.utilidad) * (1 + data.porcentajeIva / 100)));
        updatePorcentajeGanancia()
    });

    // Sincronizar cuando el input de precio de venta sea cambiado
    precioVenta.on('change', function () {
        var data = getValoresPrecios();

        var calculated_utilidad = data.precioVenta - data.costo;

        if (calculated_utilidad < 0) {
            resetToZero(data);

            return false;
        }

        utilidad.val(format_decimals(calculated_utilidad));
        utilidadIva.val(format_decimals(calculated_utilidad * (1 + data.porcentajeIva / 100)));
        precioVentaIva.val(format_decimals(data.precioVenta * (1 + data.porcentajeIva / 100)));
        updatePorcentajeGanancia()
    });

    // Sincronizar cuando el input de precio venta + iva sea cambiado
    precioVentaIva.on('change', function () {
        var data = getValoresPrecios();

        var calculated_utilidad = data.precioVentaIva / (1 + data.porcentajeIva / 100) - data.costo;

        if (calculated_utilidad < 0) {
            resetToZero(data);

            return false;
        }

        utilidad.val(format_decimals(calculated_utilidad));
        utilidadIva.val(format_decimals(calculated_utilidad * (1 + data.porcentajeIva / 100)));
        precioVenta.val(format_decimals(data.precioVentaIva / (1 + data.porcentajeIva / 100)));
        updatePorcentajeGanancia()
    });

    utilidadIva.on('change', function () {
        var data = getValoresPrecios();

        if (data.utilidadIva < 0) {
            return false;
        }

        var calculated_utilidad = data.utilidadIva / (1 + data.porcentajeIva / 100);

        utilidad.val(format_decimals(calculated_utilidad));
        precioVenta.val(format_decimals(data.costo + calculated_utilidad));
        precioVentaIva.val(format_decimals((data.costo + calculated_utilidad) * (1 + data.porcentajeIva / 100)));
        updatePorcentajeGanancia()
    });

    porcentajeGanancia.on('change', function () {
        var data = getValoresPrecios()

        if (data.porcentajeGanancia < 0) {
            resetToZero(data)
            return false;
        }

        var valUtilidadIva = data.costoConIva * (data.porcentajeGanancia / 100)
        utilidadIva.val(format_decimals(valUtilidadIva))
        utilidadIva.trigger('change')
    })
    utilidadIva.trigger('change')
});

new Vue({
    el: '#syncCostoTotal',
    data: {
        costoUnitario: 0,
        cantidad: 0,
    },
    computed: {
        costoTotal: {
            get: function () {
                return (this.costoUnitario * this.cantidad).toFixed(4)
            },
            set: function (total) {
                this.costoUnitario = (total / this.cantidad).toFixed(4)
            }
        },
    },
})