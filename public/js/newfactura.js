/**
 * Manejo de las facturas.
 */

(function () {

    // ACTUALIZAR LAS VISTAS

    var tipoFactura = $('#tipo-factura').data('tipofactura');
    var porcentajeIVA = Number($('#porcetaje-iva').data('porcentajeiva'));
    var isReadOnly = $('#read-only').data('readonly');

    var formularioFactura = $('#facturaForm');

    var tablaDetalles = $('#listaProductos');
    var detalleTemplate = $('#tr-producto-template').text();

    var tablaProductosEncontrados = $('#listaProductosEncontrados');
    var productoEntontradoTemplate = $('#tr-producto-encontrado-template').text();

    var modalDialogoCantidad = $('#modal-dialogo-cantidad');

    var almacenOptionsTemplate = $('#options-almacen-template').text();
    var almacenSelect = $('#almacenID');

    var formCantidadPrecioDetalle = $('#cantidadDetalleForm');
    var inputPrecioDetalle = $('#precioDetalle');
    var inputCantidadDetalle = $('#cantidadDetalle');

    var btnPrecioOriginal = $('#btnDetallePrecioOriginal');

    var descuentosOptionsTemplate = $('#options-descuentos-template').text();
    var descuentosSelect = $('#descuentoID');

    var outputAfectas = $('#sum-afectas');
    var outputIVA = $('#sum-iva');
    var outputSubTotal = $('#sum-sub-total');
    var outputExcentas = $('#sum-excentas');
    var outputTotal = $('#sum-total');

    var btnGuardarFactura = $('#btnGuardarFactura');
    var btnImprimirCotizacion = $('#btnImprimirCotizacion');

    var almacenParent = almacenSelect.parent().removeClass('has-error');
    var cantidadParent = inputCantidadDetalle.parent().removeClass('has-error');
    var precioParent = inputPrecioDetalle.parent().parent().removeClass('has-error');

    var clienteSelect = $('#clientePersonaID');
    var contribuyenteSelect = $('#empresaID');
    var empleadoSelect = $('#empleadoID');
    var inputCorrelativo = $('#correlativo');
    var tirajeNumCorrelativo = $('#numFacturaCorrelativo');
    var codigoTiraje = $('#txtCodigoTiraje');

    var btnEliminar = $('#btn-eliminar-factura-perma');
    var btnActivarModalEliminar = $('#btnMostrarModalEliminar');

    var formBuscarProductos = $('#buscarProductoForm');

    var outputSeleccionadoCodigo = $('#outputSeleccionadoCodigo');
    var outputSeleccionadoDescripcion = $('#outputSeleccionadoDescripcion');

    var paginacionTemplate = $('#navegacion-productos-template').text();
    var outputPagination = $('#outputPagination');

    // MODIFICAR LA VISTA DE LA FACTURA SEGÚN EL TIPO DE FACTURA (CONSUMIDOR FINAL Y CRÉDITO FISCAL).
    (function () {
        if (tipoFactura == 1) {
            $('.factura-only').removeClass('hidden');
        }

        if (tipoFactura == 2) {
            $('.credito-only').removeClass('hidden');
        }

        if (tipoFactura == 3) {
            // No es factura, es cotización.
            $('.cotizacion-hidden').addClass('hidden');
            $('.cotizacion-show').removeClass('hidden');
        }

        if (isReadOnly == 1) {
            $('.readonly-hidden').addClass('hidden');
            $('.readonly-disabled').prop('disabled', true);
            $('.readonly-show').removeClass('hidden');

            submitMethod.send(window.location.pathname, 'get', null, 'factura-get-existent');
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
        var sumaIva;
        var sumaSubTotal;
        var sumaTotal;

        for (var key in listaDetalles) {
            if (listaDetalles.hasOwnProperty(key)) {
                sumaAfectas += Number(listaDetalles[key].afectas);
                sumaExentas += Number(listaDetalles[key].excentas);
                tablaDetalles.append(Mustache.render(detalleTemplate, listaDetalles[key]));
            }
        }

        sumaIva = sumaAfectas - sumaAfectas / (1 + porcentajeIVA / 100);
        sumaSubTotal = sumaAfectas;
        sumaTotal = sumaAfectas + sumaExentas;

        if (tipoFactura == 2) {
            sumaAfectas -= sumaIva;
        }

        outputAfectas.text(sumaAfectas.toFixed(2));
        outputIVA.text(sumaIva.toFixed(2));
        outputSubTotal.text(sumaSubTotal.toFixed(2));
        outputExcentas.text(sumaExentas.toFixed(2));
        outputTotal.text(sumaTotal.toFixed(2));
    });

    eventos.on('updateFacturasProductosView', function (listaProductos) {
        tablaProductosEncontrados.html('');
        for (var key in listaProductos) {
            if (listaProductos.hasOwnProperty(key)) {
                tablaProductosEncontrados.append(Mustache.render(productoEntontradoTemplate, listaProductos[key]));
            }
        }
    });

    eventos.on('updatePaginacionEncontrados', function (pag) {
        outputPagination.html('');

        var pages = [];

        for (var i = pag.currentPage - 3; i < pag.currentPage + 3; i++) {
            if (i < 1) continue;
            if (i > pag.totalPages) continue;

            pages.push({
                number: i,
                active: i == pag.currentPage
            });
        }

        var view = {
            disablePrev: pag.currentPage <= 1,
            valuePrev: pag.currentPage - 1,
            pages: pages,
            disableNext: pag.currentPage >= pag.totalPages,
            valueNext: pag.currentPage + 1
        };
        outputPagination.html(Mustache.render(paginacionTemplate, view));
    });

    eventos.on('updateOrderBy', function (orderby) {
        $('a.link-submit[data-input="orderby"]').each(function (_, elem) {
            var title = $(elem);
            if (title.data('value') === orderby) {
                title.text(title.data('friendlyname') + ' ▼');
            } else {
                title.text(title.data('friendlyname'));
            }
        });
    });

    eventos.on('factura-open-dialogo-cantidad', function (datos) {
        modalDialogResetValidationStatus();

        outputSeleccionadoCodigo.text(datos.producto.codigoProducto);
        outputSeleccionadoDescripcion.text(datos.producto.descripcion);

        almacenSelect.html(Mustache.render(almacenOptionsTemplate, {
            almacenes: datos.almacenes
        }));

        descuentosSelect.html(Mustache.render(descuentosOptionsTemplate, {
            descuentos: datos.descuentos
        }));

        inputCantidadDetalle.val(0);

        inputPrecioDetalle.val(datos.precio);
        inputPrecioDetalle.data('preciooriginal', datos.precio);
        inputPrecioDetalle.attr('min', datos.precioMin);

        modalDialogoCantidad.modal('show');

        almacenSelect.focus();
    });

    eventos.on('factura-saved-success', function () {
        facturas.clear();
        facturas.productos.clear();

        var nextCorr = Number(inputCorrelativo.val()) + 1;

        // inputCorrelativo.data('min', nextCorr);
        // inputCorrelativo.val(nextCorr);

        // tirajeNumCorrelativo.text(nextCorr);

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

    eventos.on('factura-existente-failed', function () {
        eventos.emit('alert-feedback', {
            context: 'danger',
            icon: 'remove-sign',
            message: 'No se obtuvieron los datos para mostrar la factura.'
        });

        inputCorrelativo.val('');
        tirajeNumCorrelativo.text('--');
        codigoTiraje.text('--');
        clienteSelect.val('');
        contribuyenteSelect.val('');
        empleadoSelect.val('');

        btnActivarModalEliminar.prop('disabled', true);
    });

    eventos.on('factura-existente-success', function (datos) {
        inputCorrelativo.val('');
        tirajeNumCorrelativo.text(datos.correlativo);
        codigoTiraje.text(datos.codigoTiraje);
        clienteSelect.val(datos.clienteID);
        contribuyenteSelect.val(datos.empresaID);
        empleadoSelect.val(datos.empleadoID);
    });

    eventos.on('factura-existente-finished', function () {
        $('.factura-eliminar-detalle')
            .removeClass('trigger-event')
            .removeClass('text-danger')
            .addClass('text-faint')
            .addClass('cursor-disabled');
    });

    eventos.on('factura-eliminada', function (datos) {
        if (datos.status == "error") {
            eventos.emit('alert-feedback', {
                context: 'danger',
                icon: 'remove-sign',
                message: 'No se pudo eliminar la factura.'
            });
            return false;
        }
        if (datos.status == "success") {
            eventos.emit('alert-feedback', {
                context: 'success',
                icon: 'ok',
                message: 'Se eliminó la factura exitosamente!'
            });
            btnEliminar.prop('disabled', true);
            btnActivarModalEliminar.prop('disabled', true);
        }
    });

    formBuscarProductos.on('submit', function (e) {
        e.preventDefault();

        submitMethod.send('/productos', 'get', formBuscarProductos.serialize(), 'factura-busca-producto');

        return false;
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

    formCantidadPrecioDetalle.on('submit', function (e) {
        e.preventDefault();

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

        if (precio < Number(inputPrecioDetalle.attr('min'))) {
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

        return false;
    });

    btnGuardarFactura.on('click', function () {
        var detalles = facturas.getAllDetails();

        if ($.isEmptyObject(detalles)) {
            return false;
        }

        var clientePersonaID = clienteSelect.val();
        var clienteContribuyenteID = contribuyenteSelect.val();
        var empleadoID = empleadoSelect.val();
        var correlativoSeleccionado = inputCorrelativo.val();

        var message = {
            clienteID: clientePersonaID,
            empresaID: clienteContribuyenteID,
            empleadoID: empleadoID,
            correlativo: correlativoSeleccionado,
            ajuste: 0,
            detalles: detalles.map(function(d) {
                var copy = Object.assign({}, d)
                copy.producto = undefined
                return copy
            })
        };
        submitMethod.send(window.location.pathname, 'post', message, 'factura-new-saved');
    });

    btnImprimirCotizacion.on('click', function () {
        var clientePersonaID = clienteSelect.val();
        var empleadoID = empleadoSelect.val();
        var detalles = facturas.getAllDetails();
        var message = {
            clienteID: clientePersonaID,
            empleadoID: empleadoID,
            detalles: detalles,
        }

        submitMethod.download('/cotizacion/nuevo', 'post', message, 'cotizacion-downloaded');
    });

    btnEliminar.on('click', function () {
        submitMethod.send(window.location.pathname, 'delete', null, 'factura-eliminada');
    });
}());

(function () {
    var productoActual;
    var almacenesActuales;

    var tipoFactura = $('#tipo-factura').data('tipofactura');

    var porcentajeIVA = Number($('#porcetaje-iva').data('porcentajeiva'));

    // MANEJAR RECEPCION DE DATOS DE PRODUCTOS ENCONTRADOS DESDE EL SERVIDOR
    eventos.on('factura-busca-producto', function (data) {
        facturas.productos.clear();

        data.products.forEach(function (p) {

            var iva = 1 + porcentajeIVA / 100;

            if (p.ExcentoIVA == 1) {
                iva = 1;
            }

            var precio = (Number(p.CostoActual) + Number(p.Utilidad)) * iva;

            var producto = facturas.productos.crearProducto(
                p.ProductoID, p.CategoriaProductoID, p.CodigoBienDet, p.CodigoLibroDet,
                p.CodigoProducto, p.CostoActual, p.Descripcion, p.ExcentoIVA, p.FechaCreacion,
                p.FechaModificacion, p.MarcaID, p.MedidaID, p.NombreCategoria, p.NombreMarca,
                p.Cantidad, p.StockMin, p.UnidadMedida, p.Utilidad, precio.toFixed(2)
            );

            facturas.productos.addProducto(producto);
        });

        eventos.emit('updatePaginacionEncontrados', data.pagination);
        eventos.emit('updateOrderBy', data.input.orderby);
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

        if (detalles.length == 0 && tipoFactura !== 3) {
            return false;
        }

        if (tipoFactura === 3) {
            detalles.push({
                AlmacenID: 'cot',
                Cantidad: 100000,
                DetalleAlmacenesID: null,
                NombreAlmacen: "COTIZACION",
                ProductoID: null,
            })
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
            producto: productoActual,
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

        var detalle = facturas.crearDetalle(productoActual.productoID, productoActual.codigoProducto, input.cantidad, productoActual.nombreMarca,
            productoActual.descripcion, Number(input.precio).toFixed(2), excentas.toFixed(2), afectas.toFixed(2), input.almacenID, almacen.NombreAlmacen, productoActual);

        facturas.addDetalle(detalle);
    });

    // BORRADO DE UNO O TODOS LOS DETALLES
    eventos.on('factura-eliminar-detalle', function (datos) {
        var detalleID = datos.index;

        if (detalleID == 'todos') {
            facturas.clear();

            return true;
        }

        facturas.removeDetalle(detalleID);
    });

    // ACTUALIZAR CANTIDAD DE UN DETALLE AGREGADO
    eventos.on('factura-change-cantidad-detalle', function (datos) {
        var detalle = facturas.getFromIndex(datos.detalle_id)
        if (!detalle) { return }
        detalle.cantidad = datos.cantidad

        if (detalle.producto.ExcentoIVA == 1) {
            detalle.exentas = Number(detalle.precio * detalle.cantidad).toFixed(2);
        } else {
            detalle.afectas = Number(detalle.precio * detalle.cantidad).toFixed(2);
        }

        facturas.update(detalle)
        setTimeout(function () {
            $('#input-cantidad-detalle-' + datos.detalle_id).focus()
        }, 50)
    })

    // RECIBIDO RESPUESTA DE CREACIÓN DE FACTURA EN EL SERVIDOR
    eventos.on('factura-new-saved', function (datos) {
        if (datos.status == 'success') {
            eventos.emit('factura-saved-success', null);

            return true;
        }

        eventos.emit('factura-saved-error', null);

        return false;
    });

    // RECIBIDO RESPUESTA COTIZACION PDF
    eventos.on('cotizacion-downloaded', function (datos) {
        if (datos.error) {
            eventos.emit('alert-feedback', {
                context: 'danger',
                icon: 'remove-sign',
                message: 'No se pudo crear el archivo PDF. ' + datos.error.error
            });

            return false;
        }

        eventos.emit('alert-feedback', {
            context: 'info',
            icon: 'ok',
            message: 'Reporte recibido.'
        });
    });

    // MOSTRAR DATOS DE FACTURA EXISTENTE
    eventos.on('factura-get-existent', function (datos) {

        // CAMBIAR LOS DATOS DE LA FACTURA
        if (datos.status == "error") {
            eventos.emit('factura-existente-failed', null);
            eventos.emit('factura-existente-finished', null);
            return false;
        }

        eventos.emit('factura-existente-success', datos.factura);

        datos.factura.detalles.forEach(function (detalle) {
            var exentas = 0;
            var afectas = 0;

            if (detalle.producto.ExcentoIVA == 1) {
                exentas = detalle.precioUnitario * detalle.cantidad;
            } else {
                afectas = detalle.precioUnitario * detalle.cantidad;
            }

            var almacen = datos.almacenes.filter(function (almacen) {
                return almacen.AlmacenID == detalle.almacenID;
            })[0];

            // CREAR DETALLE A PARTIR DE LA INFORMACIÓN OBTENIDA
            var newDetalle = facturas.crearDetalle(
                detalle.producto.ProductoID,
                detalle.producto.CodigoProducto,
                detalle.cantidad,
                detalle.producto.NombreMarca,
                detalle.producto.Descripcion,
                detalle.precioUnitario.toFixed(2),
                exentas.toFixed(2),
                afectas.toFixed(2),
                detalle.almacenID,
                almacen.NombreAlmacen,
                detalle.producto,
            );

            // AGREGAR DETALLE A LA FACTURA
            facturas.addDetalle(newDetalle);
        });

        eventos.emit('factura-existente-finished', null);
    })

    $('#listaProductos').on('change', '.input-cantidad-detalle', function (e) {

    })
    $('#listaProductos').on('change', '.input-cantidad-detalle', function (e) {
        e.currentTarget.value = Number(e.currentTarget.value).toFixed(0)
        if (e.currentTarget.value < 1) {
            e.currentTarget.value = 1
        }
        eventos.emit('factura-change-cantidad-detalle',  {
            detalle_id: $(e.currentTarget).data('index'),
            cantidad: e.currentTarget.value,
        })
    })
}());

var facturas = (function () {
    'use strict';

    var listaDetalles = [];

    var crearDetalle = function (id, codigo, cantidad, marca, descripcion, precio, excentas, afectas, almacenID, almacen, producto) {
        return {
            id: id,
            codigo: codigo,
            cantidad: cantidad,
            marca: marca,
            descripcion: descripcion,
            precio: precio,
            excentas: excentas,
            afectas: afectas,
            almacenID: almacenID,
            almacen: almacen,
            producto: producto,
        };
    };

    // Efecto secundario: si ya existe un producto con la misma ID, esta función  lo actualiza.
    var addDetalle = function (detalle) {
        detalle.index = new Date().getUTCMilliseconds();
        listaDetalles.push(detalle);
        eventos.emit('updateFacturaDetallesView', listaDetalles);
    };

    var removeDetalle = function (id) {
        listaDetalles = listaDetalles.filter(function (d) {
            return d.index != id;
        });
        eventos.emit('updateFacturaDetallesView', listaDetalles);
    };

    var getFromID = function (id) {
        var detalle = listaDetalles.filter(function (d) {
            return d.id === id;
        });
        return detalle[0];
    };

    var getFromIndex = function (index) {
        var detalle = listaDetalles.find(d => d.index === index)
        return detalle
    }

    var getAll = function () {
        return listaDetalles;
    };

    var clear = function () {
        listaDetalles = [];
        eventos.emit('updateFacturaDetallesView', listaDetalles);
    };
    
    var update = function (updated) {
        var idx_detalle = listaDetalles.findIndex(d => d.id === updated.id)
        if (idx_detalle < 0) { return }
        listaDetalles[idx_detalle] = updated
        eventos.emit('updateFacturaDetallesView', listaDetalles);
    }

    return {
        crearDetalle: crearDetalle,
        addDetalle: addDetalle,
        removeDetalle: removeDetalle,
        getFromID: getFromID,
        getAllDetails: getAll,
        getFromIndex: getFromIndex,
        clear: clear,
        update: update,
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