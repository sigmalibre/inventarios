/**
 * Manejo de eventos (publish subscribe pattern)
 */

var eventos = (function () {
    'use strict';

    var lista_eventos = {};

    var suscribir = function (nombre_evento, callback) {
        lista_eventos[nombre_evento] = lista_eventos[nombre_evento] || [];
        if ($.inArray(callback, lista_eventos[nombre_evento]) === -1) {
            lista_eventos[nombre_evento].push(callback);
        }
    };

    var abandonar = function (nombre_evento, callback) {
        if (lista_eventos[nombre_evento]) {
            lista_eventos[nombre_evento] = lista_eventos[nombre_evento].filter(function (funcion) {
                return funcion !== callback;
            });
        }
    };

    var emitirEvento = function (nombre_evento, datos) {
        if (lista_eventos[nombre_evento]) {
            lista_eventos[nombre_evento].forEach(function (callback) {
                callback(datos);
            });
        }
    };

    return {
        on: suscribir,
        off: abandonar,
        emit: emitirEvento
    };
}());
