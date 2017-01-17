INSERT INTO CategoriasBienDet (CodigoBienDet, Descripcion) VALUES ('01', 'Productos Terminados');
INSERT INTO CategoriasBienDet (CodigoBienDet, Descripcion) VALUES ('02', 'Productos en Proceso');
INSERT INTO CategoriasBienDet (CodigoBienDet, Descripcion) VALUES ('03', 'Materia Prima');
INSERT INTO CategoriasBienDet (CodigoBienDet, Descripcion) VALUES ('04', 'Bien para la Construcción');

INSERT INTO ReferenciaLibroDet (CodigoLibroDet, Descripcion) VALUES ('01', 'Costos');
INSERT INTO ReferenciaLibroDet (CodigoLibroDet, Descripcion) VALUES ('02', 'Retaceos');
INSERT INTO ReferenciaLibroDet (CodigoLibroDet, Descripcion) VALUES ('03', 'Compras Locales');

INSERT INTO Almacenes (AlmacenID, NombreAlmacen) VALUES ('1', 'CASA MATRIZ');

INSERT INTO TirajeFacturas (TirajeFacturaID, CodigoTiraje, TirajeDesde, TirajeHasta) VALUES ('1', 'INICIOFACTURA', '1', '10');
INSERT INTO TirajeFacturas (TirajeFacturaID, CodigoTiraje, TirajeDesde, TirajeHasta) VALUES ('2', 'INICIOCREDITO', '1', '10');

INSERT INTO TiposFactura (TipoFacturaID, Nombre, TirajeFacturaID) VALUES ('1', 'Consumidor Final', 1);
INSERT INTO TiposFactura (TipoFacturaID, Nombre, TirajeFacturaID) VALUES ('2', 'Crédito Fiscal', 2);

INSERT INTO ClientesPersonas (ClientesPersonasID, Nombres, Apellidos, DUI, NIT) VALUES ('1', 'CLIENTE', 'FACTURA', 'N/A', 'N/A');
INSERT INTO Empresas (EmpresaID, NombreComercial, RazonSocial, Giro, Registro, NIT) VALUES ('1', 'CLIENTE CREDITO', 'N/A', 'N/A', 'N/A', 'N/A');