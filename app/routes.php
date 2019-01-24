<?php

use Sigmalibre\IVA\IVAController;
use Sigmalibre\Brands\BrandsController;
use Sigmalibre\Homepage\HomeController;
use Sigmalibre\Clients\ClientsController;
use Sigmalibre\Reports\ReporteController;
use Sigmalibre\Empresas\EmpresasController;
use Sigmalibre\Ingresos\IngresosController;
use Sigmalibre\Invoices\FacturasController;
use Sigmalibre\Products\ImportarController;
use Sigmalibre\Products\ProductsController;
use Sigmalibre\Empleados\EmpleadoController;
use Sigmalibre\Products\DescuentosController;
use Sigmalibre\Providers\ProvidersController;
use Sigmalibre\Accounts\LogIn\LogInController;
use Sigmalibre\Categories\CategoriesController;
use Sigmalibre\TirajeFactura\TirajesController;
use Sigmalibre\UserConfig\UserConfigController;
use Sigmalibre\Warehouses\WarehousesController;
use Sigmalibre\Cotizaciones\CotizacionController;
use Sigmalibre\Invoices\CreditosFiscalesController;
use Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurementController;

// HOMEPAGE
$app->get('/', HomeController::class . ':home')->setName('homepage');

// PRODUCTOS
$app->get('/productos', ProductsController::class . ':indexProducts')->setName('products');

$app->get('/productos/id/{id}', ProductsController::class . ':indexProduct')->setName('products/update');
$app->post('/productos/id/{id}', ProductsController::class . ':update');
$app->delete('/productos/id/{id}', ProductsController::class . ':delete');

$app->get('/productos/id/{id}/detalles', ProductsController::class . ':getDetalleAlmacenes')->setName('products/detalles');
$app->post('/productos/id/{id}/ingresos', IngresosController::class . ':createNew')->setName('products/ingresos');
$app->post('/productos/id/{id}/ingresos/ajustes', IngresosController::class . ':ajuste')->setName('products/ingresos/ajustes');
$app->get('/productos/id/{id}/facturas/ultimo', FacturasController::class . ':ultimoWarehouse')->setName('products/facturas/ultimo');
$app->post('/productos/id/{id}/traslados', ProductsController::class . ':traslado')->setName('products/traslado');
$app->post('/productos/id/{id}/descuentos', DescuentosController::class . ':createNew')->setName('products/descuentos');
$app->get('/productos/id/{id}/descuentos', DescuentosController::class . ':getDescuentosProducto');
$app->post('/productos/id/{id}/imagen', ProductsController::class . ':picture')->setName('products/picture');

$app->get('/productos/id/{productoID}/descuentos/id/{descuentoID}', DescuentosController::class . ':indexDescuento')->setName('products/descuentos/modify');
$app->post('/productos/id/{productoID}/descuentos/id/{descuentoID}', DescuentosController::class . ':update');
$app->delete('/productos/id/{productoID}/descuentos/id/{descuentoID}', DescuentosController::class . ':delete');

$app->get('/productos/nuevo', ProductsController::class . ':indexNewProduct')->setName('products/createform');
$app->post('/productos/nuevo', ProductsController::class . ':createNew');

$app->get('/productos/importar', ImportarController::class . ':importar')->setName('importar');

$app->get('/productos/ingresos', IngresosController::class . ':indexAll')->setName('ingresos');


// CATEGORIAS DE PRODUCTO
$app->get('/categorias', CategoriesController::class . ':indexCategories')->setName('categories');

$app->get('/categorias/id/{id}', CategoriesController::class . ':indexCategory')->setName('categories/update');
$app->post('/categorias/id/{id}', CategoriesController::class . ':update');
$app->delete('/categorias/id/{id}', CategoriesController::class . ':delete');

$app->get('/categorias/nuevo', CategoriesController::class . ':indexNewCategory')->setName('categories/createform');
$app->post('/categorias/nuevo', CategoriesController::class . ':createNew');

// PROVEEDORES
$app->get('/contactos/proveedores', ProvidersController::class . ':indexProviders')->setName('providers');

// FACTURACIÓN
$app->get('/facturas', FacturasController::class . ':indexFacturas')->setName('invoices');
$app->get('/facturas/nuevo', FacturasController::class . ':indexNew')->setName('invoices/createform');
$app->post('/facturas/nuevo', FacturasController::class . ':saveNew');

$app->get('/facturas/id/{id}', FacturasController::class . ':indexNew')->setName('invoices/id');
$app->delete('/facturas/id/{id}', FacturasController::class . ':delete');

$app->get('/creditofiscal', CreditosFiscalesController::class . ':indexFacturas')->setName('creditofiscal');
$app->get('/creditofiscal/nuevo', CreditosFiscalesController::class . ':indexNew')->setName('creditofiscal/createform');
$app->post('/creditofiscal/nuevo', CreditosFiscalesController::class . ':saveNew');

$app->get('/creditofiscal/id/{id}', CreditosFiscalesController::class . ':indexNew')->setName('creditofiscal/id');
$app->delete('/creditofiscal/id/{id}', CreditosFiscalesController::class . ':delete');

// ALMACENES
$app->get('/almacenes', WarehousesController::class . ':indexWarehouses')->setName('warehouses');

$app->get('/almacenes/id/{id}', WarehousesController::class . ':indexWarehouse')->setName('warehouses/update');
$app->post('/almacenes/id/{id}', WarehousesController::class . ':update');
$app->delete('/almacenes/id/{id}', WarehousesController::class . ':delete');

$app->get('/almacenes/nuevo', WarehousesController::class . ':indexCreateWarehouse')->setName('warehouses/createform');
$app->post('/almacenes/nuevo', WarehousesController::class . ':createNew');

// CLIENTES
$app->get('/contactos/clientes/personas', ClientsController::class . ':indexPeople')->setName('clientes/personas');

$app->get('/contactos/clientes/personas/nuevo', ClientsController::class . ':indexNew')->setName('clientes/createform');
$app->post('/contactos/clientes/personas/nuevo', ClientsController::class . ':createNew');

$app->get('/contactos/clientes/personas/id/{id}', ClientsController::class . ':indexCliente')->setName('clientes/update');
$app->post('/contactos/clientes/personas/id/{id}', ClientsController::class . ':update');
$app->delete('/contactos/clientes/personas/id/{id}', ClientsController::class . ':delete');

$app->get('/contactos/clientes/empresas', ClientsController::class . ':indexCompanies')->setName('clientes/empresas');

// MARCAS
$app->get('/marcas', BrandsController::class . ':indexBrands')->setName('brands');

$app->get('/marcas/id/{id}', BrandsController::class . ':indexBrand')->setName('brands/update');
$app->post('/marcas/id/{id}', BrandsController::class . ':update');
$app->delete('/marcas/id/{id}', BrandsController::class . ':delete');

// UNIDADES DE MEDIDA
$app->get('/medidas', UnitsOfMeasurementController::class . ':indexMeasurements')->setName('measurements');

$app->get('/medidas/id/{id}', UnitsOfMeasurementController::class . ':indexUnit')->setName('measurements/update');
$app->post('/medidas/id/{id}', UnitsOfMeasurementController::class . ':update');
$app->delete('/medidas/id/{id}', UnitsOfMeasurementController::class . ':delete');

// TIRAJE FACTURAS
$app->get('/tirajes', TirajesController::class . ':indexListaTirajes')->setName('tirajes');

$app->get('/tirajes/id/{id}', TirajesController::class . ':indexTiraje')->setName('tirajes/update');
$app->post('/tirajes/id/{id}', TirajesController::class . ':update');
$app->delete('/tirajes/id/{id}', TirajesController::class . ':delete');

$app->get('/tirajes/nuevo', TirajesController::class . ':indexNew')->setName('tirajes/createform');
$app->post('/tirajes/nuevo', TirajesController::class . ':createNew');

// AJUSTES DE USUARIO
$app->get('/ajustes', UserConfigController::class . ':index')->setName('ajustes');
$app->post('/ajustes/empresa', UserConfigController::class . ':setEmpresa')->setName('ajustes/empresa');
$app->post('/ajustes/tirajes', UserConfigController::class . ':setTirajes')->setName('ajustes/tirajes');

// IVA
$app->get('/iva', IVAController::class . ':index')->setName('iva');
$app->post('/iva', IVAController::class . ':update');

// CONTACTOS
$app->get('/contactos/empresas', EmpresasController::class . ':indexEmpresas')->setName('empresas');

$app->get('/contactos/empresas/nuevo', EmpresasController::class . ':indexNew')->setName('empresas/createform');
$app->post('/contactos/empresas/nuevo', EmpresasController::class . ':createNew');

$app->get('/contactos/empresas/id/{id}', EmpresasController::class . ':indexEmpresa')->setName('empresa');
$app->post('/contactos/empresas/id/{id}', EmpresasController::class . ':update');
$app->delete('/contactos/empresas/id/{id}', EmpresasController::class . ':delete');

// EMPLEADOS
$app->get('/contactos/empleados', EmpleadoController::class . ':indexEmpleados')->setName('empleados');

$app->get('/contactos/empleados/nuevo', EmpleadoController::class . ':indexNew')->setName('empleados/createform');
$app->post('/contactos/empleados/nuevo', EmpleadoController::class . ':createNew');

$app->get('/contactos/empleados/id/{id}', EmpleadoController::class . ':indexEmpleado')->setName('empleado');
$app->post('/contactos/empleados/id/{id}', EmpleadoController::class . ':update');
$app->delete('/contactos/empleados/id/{id}', EmpleadoController::class . ':delete');

// REPORTES

$app->get('/reportes', ReporteController::class . ':index')->setName('reportes');

$app->get('/reportes/test', ReporteController::class . ':testReporte');

$app->get('/reportes/det', ReporteController::class . ':detPRN');

$app->get('/reportes/conteo', ReporteController::class . ':conteoInventario');

$app->get('/reportes/resumenexistencia', ReporteController::class . ':resumenExistencia');

$app->get('/reportes/rendimiento', ReporteController::class . ':rendimiento');

// COTIZACIONES

$app->get('/cotizacion/nuevo', CotizacionController::class . ':index')->setName('cotizacion');
$app->post('/cotizacion/nuevo', CotizacionController::class. ':report');

// SESIONES

$app->get('/login', LogInController::class . ':index')->setName('login');
$app->post('/login', LogInController::class . ':iniciarSesion');
$app->post('/login/nuevo', LogInController::class . ':newUser')->setName('login/nuevo');
