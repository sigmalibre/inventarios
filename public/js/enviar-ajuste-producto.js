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
	}
})
