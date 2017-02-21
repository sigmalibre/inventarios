/**
 * MANEJA EL ELIMINADO DE MARCAS DE PRODUCTO.
 */

(function () {
    eventos.on('eliminar-marca-productos', function () {
        console.log('eliminando productos...');
    });

    eventos.on('eliminar-marca-mover-productos', function () {
        console.log('moviendo productos...');
    });
}());