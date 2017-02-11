/**
 * Manejo de las facturas.
 */

(function () {

    // ACTUALIZAR LAS VISTAS

    var serverData = $('#server-data');

    var formularioFactura = $('#facturaForm');

    var tablaDetalles = $('#listaProductos');
    var detalleTemplate = $('#tr-producto-template').text();

    var tablaProductosEncontrados = $('#listaProductosEncontrados');
    var productoEntontradoTemplate = $('#tr-producto-encontrado-template').text();

    var modalDialogoCantidad = $('#modal-dialogo-cantidad');

    var almacenOptionsTemplate = $('#options-almacen-template').text();
    var almacenSelect = $('#almacenID');

    var inputPrecioDetalle = $('#precioDetalle');
    var inputCantidadDetalle = $('#cantidadDetalle');

    var btnPrecioOriginal = $('#btnDetallePrecioOriginal');

    var descuentosOptionsTemplate = $('#options-descuentos-template').text();
    var descuentosSelect = $('#descuentoID');

    var btnCrearDetalle = $('#btnCrearDetalle');

    var outputAfectas = $('#sum-afectas');
    var outputExcentas = $('#sum-excentas');
    var outputTotal = $('#sum-total');

    var btnGuardarFactura = $('#btnGuardarFactura');

    var almacenParent = almacenSelect.parent().removeClass('has-error');
    var cantidadParent = inputCantidadDetalle.parent().removeClass('has-error');
    var precioParent = inputPrecioDetalle.parent().parent().removeClass('has-error');

    var clienteSelect = $('#clientePersonaID');
    var contribuyenteSelect = $('#empresaID');
    var inputCorrelativo = $('#correlativo');
    var tirajeNumCorrelativo = $('#numFacturaCorrelativo');

    var selectClientePersona = $('#selectClientePersona');
    var selectClienteContribuyente = $('#selectClienteContribuyente');

    // MODIFICAR LA VISTA DE LA FACTURA SEGÚN EL TIPO DE FACTURA (CONSUMIDOR FINAL Y CRÉDITO FISCAL).
    (function () {
        var tipoFactura = serverData.find('#tipo-factura').data('tipofactura');

        // MOSTRAR EL SELECT DEL CLIENTE SEGÚN EL TIPO DE FACTURA: CLIENTES PERSONAS PARA FACTURAS
        // DE CONSUMIDOR FINAL Y EMPRESAS PARA CONPROBANTE CRÉDITO FISCAL.
        if (tipoFactura == 1) {
            selectClientePersona.removeClass('hidden');
        }

        if (tipoFactura == 2) {
            selectClienteContribuyente.removeClass('hidden');
        }
    }());

    var modalDialogResetValidationStatus = function () {
        almacenParent.removeClass('has-error');
        cantidadParent.removeClass('has-error');
        precioParent.removeClass('has-error');
    };

    eventos.on('updateFacturaDetallesView', function (listaDetalles) {
        tablaDetalles.html('');

        var sumaAfectas = 0;
        var sumaExentas = 0;

        for (var key in listaDetalles) {
            if (listaDetalles.hasOwnProperty(key)) {
                sumaAfectas += Number(listaDetalles[key].afectas);
                sumaExentas += Number(listaDetalles[key].excentas);
                tablaDetalles.append(Mustache.render(detalleTemplate, listaDetalles[key]));
            }
        }

        outputAfectas.text('$ ' + sumaAfectas.toFixed(2));
        outputExcentas.text('$ ' + sumaExentas.toFixed(2));
        outputTotal.text('$ ' + (sumaAfectas + sumaExentas).toFixed(2));
    });

    eventos.on('updateFacturasProductosView', function (listaProductos) {
        tablaProductosEncontrados.html('');
        for (var key in listaProductos) {
            if (listaProductos.hasOwnProperty(key)) {
                tablaProductosEncontrados.append(Mustache.render(productoEntontradoTemplate, listaProductos[key]));
            }
        }
    });

    eventos.on('factura-open-dialogo-cantidad', function (datos) {
        modalDialogResetValidationStatus();

        almacenSelect.html(Mustache.render(almacenOptionsTemplate, {
            almacenes: datos.almacenes
        }));

        descuentosSelect.html(Mustache.render(descuentosOptionsTemplate, {
            descuentos: datos.descuentos
        }));

        inputCantidadDetalle.val(0);

        inputPrecioDetalle.val(datos.precio);
        inputPrecioDetalle.data('preciooriginal', datos.precio);
        inputPrecioDetalle.data('min', datos.precioMin);

        modalDialogoCantidad.modal('show');
    });

    eventos.on('factura-saved-success', function () {
        facturas.clear();
        facturas.productos.clear();

        var nextCorr = Number(inputCorrelativo.val()) + 1;

        // inputCorrelativo.data('min', nextCorr);
        inputCorrelativo.val(nextCorr);

        tirajeNumCorrelativo.text(nextCorr);

        eventos.emit('alert-feedback', {
            context: 'success',
            icon: 'ok',
            message: 'Se guardó la factura exitosamente!'
        });
    });

    eventos.on('factura-saved-error', function () {
        eventos.emit('alert-feedback', {
            context: 'danger',
            icon: 'remove-sign',
            message: 'La factura no pudo ser guardada.'
        });
    });

    formularioFactura.on('submit', function () {
        return false;
    });

    btnPrecioOriginal.on('click', function () {
        inputPrecioDetalle.val(Number(inputPrecioDetalle.data('preciooriginal')).toFixed(2));
    });

    almacenSelect.on('change', function () {
        inputCantidadDetalle.val(0);
        inputCantidadDetalle.data('max', almacenSelect.find(':selected').data('cantidad'));
    });

    descuentosSelect.on('change', function () {
        var cantidadDescontada = Number(descuentosSelect.find(':selected').data('cantidad'));
        var precioOriginal = Number(inputPrecioDetalle.data('preciooriginal'));

        if (cantidadDescontada == 0) {
            inputPrecioDetalle.val(precioOriginal.toFixed(2));
            inputPrecioDetalle.prop('disabled', false);
            btnPrecioOriginal.prop('disabled', false);

            return;
        }

        inputPrecioDetalle.val((precioOriginal - cantidadDescontada).toFixed(2));
        inputPrecioDetalle.prop('disabled', true);
        btnPrecioOriginal.prop('disabled', true);
    });

    btnCrearDetalle.on('click', function () {
        modalDialogResetValidationStatus();

        var goodToGo = true;

        var almacenID = almacenSelect.val();
        var cantidad = +Number(inputCantidadDetalle.val()).toFixed();
        var precio = +Number(inputPrecioDetalle.val()).toFixed(2);

        if (almacenID == 0) {
            almacenParent.addClass('has-error');
            goodToGo = false
        }

        if (cantidad <= 0 || cantidad > Number(inputCantidadDetalle.data('max'))) {
            cantidadParent.addClass('has-error');
            goodToGo = false;
        }

        if (precio < Number(inputPrecioDetalle.data('min'))) {
            precioParent.addClass('has-error');
            goodToGo = false;
        }


        if (goodToGo == false) {
            return false;
        }

        modalDialogoCantidad.modal('hide');

        eventos.emit('factura-crear-detalle', {
            almacenID: almacenID,
            cantidad: cantidad,
            precio: precio
        });
    });

    btnGuardarFactura.on('click', function () {
        var detalles = facturas.getAllDetails();

        if ($.isEmptyObject(detalles)) {
            return false;
        }

        var clientePersonaID = clienteSelect.val();
        var clienteContribuyenteID = contribuyenteSelect.val();
        var correlativoSeleccionado = inputCorrelativo.val();

        var message = {
            clienteID: clientePersonaID,
            empresaID: clienteContribuyenteID,
            correlativo: correlativoSeleccionado,
            detalles: detalles
        };

        submitMethod.send(window.location.pathname, 'post', message, 'factura-new-saved');
    });
}());

(function () {
    var productoActual;
    var almacenesActuales;

    // MANEJAR RECEPCION DE DATOS DE PRODUCTOS ENCONTRADOS DESDE EL SERVIDOR
    eventos.on('factura-busca-producto', function (data) {

        var iva = 1 + Number(data.porcentajeIVA) / 100;

        facturas.productos.clear();

        data.products.forEach(function (p) {

            if (p.ExcentoIVA == 1) {
                iva = 1;
            }

            var precio = (Number(p.CostoActual) * iva) + Number(p.Utilidad);

            var producto = facturas.productos.crearProducto(
                p.ProductoID, p.CategoriaProductoID, p.CodigoBienDet, p.CodigoLibroDet,
                p.CategoriaProductoID + p.CodigoProducto, p.CostoActual, p.Descripcion, p.ExcentoIVA, p.FechaCreacion,
                p.FechaModificacion, p.MarcaID, p.MedidaID, p.NombreCategoria, p.NombreMarca,
                p.Cantidad, p.StockMin, p.UnidadMedida, p.Utilidad, precio.toFixed(2)
            );

            facturas.productos.addProducto(producto);
        });
    });

    // MANEJAR SELECCION DE PRODUCTOS Y AGREGARLOS A LOS DETALLES

    // PASO 1: El usuario hace click en un producto de la lista de los encontrados en la búsqueda.
    eventos.on('factura-producto-selected', function (data) {
        var producto = facturas.productos.getFromID(data.productoid);

        if (!producto) {
            return false;
        }

        productoActual = producto;

        // Request para obtener los almacenes del producto
        submitMethod.send('/productos/id/' + producto.productoID + '/detalles', 'get', null, 'factura-obtuvo-almacenes');
    });

    // PASO 2: Se recibió la información sobre los almacenes donde hay disponible el producto seleccionado.
    eventos.on('factura-obtuvo-almacenes', function (detalles) {

        if (detalles.length == 0) {
            return false;
        }

        almacenesActuales = detalles;

        // Request para obtener los descuentos del producto
        submitMethod.send('/productos/id/' + productoActual.productoID + '/descuentos', 'get', null, 'factura-obtuvo-descuentos');
    });

    // PASO 3: Obtener la lista con los descuentos aplicables para el producto.
    eventos.on('factura-obtuvo-descuentos', function (descuentos) {
        descuentos.map(function (descuento) {
            descuento.CantidadDescontada = Number(descuento.CantidadDescontada).toFixed(2);
            return descuento;
        });

        eventos.emit('factura-open-dialogo-cantidad', {
            almacenes: almacenesActuales,
            descuentos: descuentos,
            precio: productoActual.precio,
            precioMin: Number(productoActual.utilidad).toFixed(2)
        });
    });

    // PASO 4: Obtener el input del usuario y crear el detalle
    eventos.on('factura-crear-detalle', function (input) {
        var excentas = 0;
        var afectas = 0;

        if (productoActual.excentoIVA == 1) {
            excentas = input.precio * input.cantidad;
        } else {
            afectas = input.precio * input.cantidad;
        }

        var almacen = almacenesActuales.filter(function (almacen) {
            return almacen.AlmacenID == input.almacenID;
        })[0];

        var detalle = facturas.crearDetalle(productoActual.productoID, productoActual.codigoProducto, input.cantidad,
            productoActual.descripcion, Number(input.precio).toFixed(2), excentas.toFixed(2), afectas.toFixed(2), input.almacenID, almacen.NombreAlmacen);

        facturas.addDetalle(detalle);
    });

    // BORRADO DE UNO O TODOS LOS DETALLES
    eventos.on('factura-eliminar-detalle', function (datos) {
        var detalleID = datos.detalleid;

        if (detalleID == 'todos') {
            facturas.clear();

            return true;
        }

        facturas.removeDetalle(detalleID);
    });

    // RECIBIDO RESPUESTA DE CREACIÓN DE FACTURA EN EL SERVIDOR
    eventos.on('factura-new-saved', function (datos) {
        if (datos.status == 'success') {
            eventos.emit('factura-saved-success', null);

            return true;
        }

        eventos.emit('factura-saved-error', null);

        return false;
    })
}());

var facturas = (function () {
    'use strict';

    var listaDetalles = {};

    var crearDetalle = function (id, codigo, cantidad, descripcion, precio, excentas, afectas, almacenID, almacen) {
        return {
            id: id,
            codigo: codigo,
            cantidad: cantidad,
            descripcion: descripcion,
            precio: precio,
            excentas: excentas,
            afectas: afectas,
            almacenID: almacenID,
            almacen: almacen
        };
    };

    // Efecto secundario: si ya existe un producto con la misma ID, esta función  lo actualiza.
    var addDetalle = function (detalle) {
        listaDetalles[detalle.id] = detalle;
        eventos.emit('updateFacturaDetallesView', listaDetalles);
    };

    var removeDetalle = function (id) {
        delete listaDetalles[id];
        eventos.emit('updateFacturaDetallesView', listaDetalles);
    };

    var getFromID = function (id) {
        return listaDetalles[id];
    };

    var getAll = function () {
        return listaDetalles;
    };

    var clear = function () {
        listaDetalles = {};
        eventos.emit('updateFacturaDetallesView', listaDetalles);
    };

    return {
        crearDetalle: crearDetalle,
        addDetalle: addDetalle,
        removeDetalle: removeDetalle,
        getFromID: getFromID,
        getAllDetails: getAll,
        clear: clear
    }
}());

facturas.productos = (function () {
    'use strict';

    var listaProductos = {};

    var producto = {
        init: function (productoID, categoriaProductoID, codigoBienDet, codigoLibroDet,
                        codigoProducto, costoActual, descripcion, excentoIVA, fechaCreacion,
                        fechaModificacion, marcaID, medidaID, nombreCategoria, nombreMarca,
                        cantidad, stockMin, unidadMedida, utilidad, precio) {

            this.productoID = productoID;
            this.cantidad = cantidad;
            this.categoriaProductoID = categoriaProductoID;
            this.codigoBienDet = codigoBienDet;
            this.codigoLibroDet = codigoLibroDet;
            this.codigoProducto = codigoProducto;
            this.costoActual = costoActual;
            this.descripcion = descripcion;
            this.excentoIVA = excentoIVA;
            this.fechaCreacion = fechaCreacion;
            this.fechaModificacion = fechaModificacion;
            this.marcaID = marcaID;
            this.medidaID = medidaID;
            this.nombreCategoria = nombreCategoria;
            this.nombreMarca = nombreMarca;
            this.stockMin = stockMin;
            this.unidadMedida = unidadMedida;
            this.utilidad = utilidad;
            this.precio = precio;

            return this;
        }
    };

    var crearProducto = function (productoID, categoriaProductoID, codigoBienDet, codigoLibroDet,
                                  codigoProducto, costoActual, descripcion, excentoIVA, fechaCreacion,
                                  fechaModificacion, marcaID, medidaID, nombreCategoria, nombreMarca,
                                  cantidad, stockMin, unidadMedida, utilidad, precio) {

        return Object.create(producto).init(productoID, categoriaProductoID, codigoBienDet, codigoLibroDet,
            codigoProducto, costoActual, descripcion, excentoIVA, fechaCreacion,
            fechaModificacion, marcaID, medidaID, nombreCategoria, nombreMarca,
            cantidad, stockMin, unidadMedida, utilidad, precio);
    };

    // Efecto secundario: si ya existe un producto con la misma ID, esta función  lo actualiza.
    var addProducto = function (producto) {
        listaProductos[producto.productoID] = producto;
        eventos.emit('updateFacturasProductosView', listaProductos)
    };

    var removeProducto = function (producto) {
        delete listaProductos[producto.productoID];
        eventos.emit('updateFacturasProductosView', listaProductos);
    };

    var getFromID = function (id) {
        return listaProductos[id];
    };

    var getAll = function () {
        return listaProductos;
    };

    var clear = function () {
        listaProductos = {};
        eventos.emit('updateFacturasProductosView', listaProductos);
    };

    return {
        crearProducto: crearProducto,
        addProducto: addProducto,
        removeProducto: removeProducto,
        getFromID: getFromID,
        getAllDetails: getAll,
        clear: clear
    }
}());