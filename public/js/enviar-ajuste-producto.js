$('body').on('keypress', '.productos-ajustes-inputs', function (e) {
	if (event.which !== 13) { return }
	var input = $(e.currentTarget)
	var valor_ajuste = Number(input.val())
	var productoID = input.data().producto
	var valor_actual = $('#productocantidad' + productoID)
	if (valor_ajuste === 0) { return }
	if (valor_ajuste > 0) {
		$.ajax({
			url: '/productos/id/' + productoID + '/ingresos/ajustes',
			method: 'POST',
			data: {
				ajuste: valor_ajuste,
			},
			success: function(res) {
				if (!res.success) {
					return eventos.emit('alert-feedback', {
			    context: 'danger',
			    icon: 'remove-sign',
			    message: 'No se pudo ajustar el producto.'
			})
				}

				valor_actual.text(Number(valor_actual.text()) + Number(valor_ajuste))
				input.val('0')
			},
		})
	}
	if (valor_ajuste < 0) {
		if (Number(valor_actual.text()) < Number(valor_ajuste,
			) * -1) {
			return eventos.emit('alert-feedback', {
			    context: 'danger',
			    icon: 'remove-sign',
			    message: 'No se puede quitar más cantidad de la que existe.'
			})
		}

		$.ajax({
			url: '/productos/id/' + productoID + '/facturas/ultimo',
			success: function (resa) {
				if (!resa.success) {
					return eventos.emit('alert-feedback', {
					    context: 'danger',
					    icon: 'remove-sign',
					    message: 'No se encontró una última factura para tomar datos del ajuste.'
					})	
				}

				$.ajax({
					url: '/productos/id/' + productoID,
					dataType: 'json',
					success: function(res) {
						var utilidadProducto = Number(res.input.utilidadProducto)
						var valorCostoActualTotal = Number(res.input.valorCostoActualTotal)
						var porcentajeIVA = Number(res.porcentajeIVA)
						$.ajax({
							url: '/facturas/nuevo',
							method: 'POST',
							data: {
								detalles: [{
									id: productoID,
									almacenID: resa.ultimo.AlmacenID,
									cantidad: Math.abs(valor_ajuste),
									precio: (utilidadProducto + valorCostoActualTotal) * ( 1 + porcentajeIVA / 100),
								}],
							},
							success: function (resb) {
								if (resb.status !== 'success') {
									return eventos.emit('alert-feedback', {
									    context: 'danger',
									    icon: 'remove-sign',
									    message: 'No se pudo realizar el ajuste.'
									})
								}
								valor_actual.text(Number(valor_actual.text()) + Number(valor_ajuste))
								input.val('0')
							},
							error: function() {
								eventos.emit('alert-feedback', {
								    context: 'danger',
								    icon: 'remove-sign',
								    message: 'No se pudo crear la factura de ajuste.'
								})
							},
						})
					},
					error: function() {
						eventos.emit('alert-feedback', {
						    context: 'danger',
						    icon: 'remove-sign',
						    message: 'No se pudieron obtener detalles del producto.'
						})
					},
				})
			},
			error: function() {
				eventos.emit('alert-feedback', {
				    context: 'danger',
				    icon: 'remove-sign',
				    message: 'No se encontró una última factura para tomar datos del ajuste.[2]'
				})
			},
		})


		// send to new factura
		// clienteID: 
		// empresaID: 
		// correlativo: 3
		// detalles[0][id]: 4558
		// detalles[0][codigo]: 834jgnk
		// detalles[0][cantidad]: 5
		// detalles[0][marca]: Sin Marca
		// detalles[0][descripcion]: hgq8h
		// detalles[0][precio]: 4.26
		// detalles[0][excentas]: 0.00
		// detalles[0][afectas]: 21.30
		// detalles[0][almacenID]: 1
		// detalles[0][almacen]: CASA MATRIZ
		// detalles[0][index]: 835

		// we need to:
		// send data to: POST /facturas/nuevo

		// needed data
		// 'almacenID' => $detalle['almacenID'] ?? null,
		// 'cantidad' => (int)$detalle['cantidad'] ?? null, \\\\\ READY
		// 'precio' => (float)$detalle['precio: '] ?? null, \\\\\ READY
		// 'productoID' => $detalle['id'] ?? null, \\\\\ READY

		// get product data: $.ajax({ url: 'http://localhost:9001/productos/id/4558', dataType: "json" })

		// calculate price
		// utilidadProducto:"1.7699"	
		// valorCostoActualTotal:"2.0000"
		// porcentajeIVA: 13
		// (utilidadProducto + valorCostoActualTotal) * ( 1 + porcentajeIVA / 100)

		// get almacen details: http://localhost:9001/productos/id/4558/detalles
		// [{"DetalleAlmacenesID":1,"Cantidad":1030,"AlmacenID":1,"NombreAlmacen":"CASA MATRIZ","ProductoID":4558},{"DetalleAlmacenesID":2,"Cantidad":151,"AlmacenID":2,"NombreAlmacen":"SUCURSAL CENTRO","ProductoID":4558}]
	}
})
