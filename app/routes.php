<?php

use Sigmalibre\Brands\BrandsController;
use Sigmalibre\Categories\CategoriesController;
use Sigmalibre\Clients\ClientsController;
use Sigmalibre\Empresas\EmpresasController;
use Sigmalibre\Homepage\HomeController;
use Sigmalibre\Ingresos\IngresosController;
use Sigmalibre\Invoices\CreditosFiscalesController;
use Sigmalibre\Invoices\FacturasController;
use Sigmalibre\IVA\IVAController;
use Sigmalibre\Products\DescuentosController;
use Sigmalibre\Products\ImportarController;
use Sigmalibre\Products\ProductsController;
use Sigmalibre\Providers\ProvidersController;
use Sigmalibre\Reports\ReporteController;
use Sigmalibre\TirajeFactura\TirajesController;
use Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurementController;
use Sigmalibre\UserConfig\UserConfigController;
use Sigmalibre\Warehouses\WarehousesController;

// HOMEPAGE
$app->get('/', HomeController::class . ':home')->setName('homepage');

// PRODUCTOS
$app->get('/productos', ProductsController::class . ':indexProducts')->setName('products');

$app->get('/productos/id/{id}', ProductsController::class . ':indexProduct')->setName('products/update');
$app->post('/productos/id/{id}', ProductsController::class . ':update');
$app->delete('/productos/id/{id}', ProductsController::class . ':delete');

$app->get('/productos/id/{id}/detalles', ProductsController::class . ':getDetalleAlmacenes')->setName('products/detalles');
$app->post('/productos/id/{id}/ingresos', IngresosController::class . ':createNew')->setName('products/ingresos');
$app->post('/productos/id/{id}/traslados', ProductsController::class . ':traslado')->setName('products/traslado');
$app->post('/productos/id/{id}/descuentos', DescuentosController::class . ':createNew')->setName('products/descuentos');
$app->get('/productos/id/{id}/descuentos', DescuentosController::class . ':getDescuentosProducto');

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

// REPORTES

$app->get('/reportes/test', ReporteController::class . ':testReporte');
