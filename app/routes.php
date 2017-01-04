<?php

// HOMEPAGE
$app->get('/', '\Sigmalibre\Homepage\HomeController:home')->setName('homepage');

// PRODUCTOS
$app->get('/productos', '\Sigmalibre\Products\ProductsController:indexProducts')->setName('products');
$app->post('/productos', '\Sigmalibre\Products\ProductsController:createNew');

$app->get('/productos/id/{id}', '\Sigmalibre\Products\ProductsController:indexProduct');
$app->post('/productos/id/{id}', '\Sigmalibre\Products\ProductsController:update');

$app->get('/productos/createform', '\Sigmalibre\Products\ProductsController:indexNewProduct')->setName('products/createform');

$app->get('/productos/importar', '\Sigmalibre\Products\ImportarController:importar')->setName('importar');

$app->post('/productos/id/{id}/ingresos', '\Sigmalibre\Ingresos\IngresosController:createNew')->setName('ingresos');

// CATEGORIAS DE PRODUCTO
$app->get('/categorias', '\Sigmalibre\Categories\CategoriesController:indexCategories')->setName('categories');
$app->post('/categorias', '\Sigmalibre\Categories\CategoriesController:createNew');

$app->get('/categorias/id/{id}', '\Sigmalibre\Categories\CategoriesController:indexCategory');
$app->post('/categorias/id/{id}', '\Sigmalibre\Categories\CategoriesController:update');

$app->get('/categorias/createform', '\Sigmalibre\Categories\CategoriesController:indexNewCategory')->setName('categories/createform');

// PROVEEDORES
$app->get('/proveedores', '\Sigmalibre\Providers\ProvidersController:indexProviders')->setName('providers');

// FACTURACIÓN
$app->get('/facturas', '\Sigmalibre\Invoices\InvoicesController:indexInvoices')->setName('invoices');

$app->get('/creditofiscal', '\Sigmalibre\Invoices\InvoicesController:indexCreditoFiscal')->setName('creditofiscal');

// ALMACENES
$app->get('/warehouses', '\Sigmalibre\Warehouses\WarehousesController:indexWarehouses')->setName('warehouses');

// CLIENTES
$app->get('/clientes/personas', '\Sigmalibre\Clients\ClientsController:indexPeople')->setName('clientes/personas');
$app->get('/clientes/empresas', '\Sigmalibre\Clients\ClientsController:indexCompanies')->setName('clientes/empresas');

// MARCAS
$app->get('/marcas', '\Sigmalibre\Brands\BrandsController:indexBrands')->setName('brands');

$app->get('/marcas/id/{id}', '\Sigmalibre\Brands\BrandsController:indexBrand');
$app->post('/marcas/id/{id}', '\Sigmalibre\Brands\BrandsController:update');

// UNIDADES DE MEDIDA
$app->get('/medidas', '\Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurementController:indexMeasurements')->setName('measurements');

$app->get('/medidas/id/{id}', '\Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurementController:indexUnit');
$app->post('/medidas/id/{id}', '\Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurementController:update');

// TIRAJE FACTURAS
$app->get('/tirajes', '\Sigmalibre\TirajeFactura\TirajesController:indexListaTirajes')->setName('tirajes');
$app->post('/tirajes', '\Sigmalibre\TirajeFactura\TirajesController:createNew');

$app->get('/tirajes/id/{id}', '\Sigmalibre\TirajeFactura\TirajesController:indexTiraje');
$app->post('/tirajes/id/{id}', '\Sigmalibre\TirajeFactura\TirajesController:update');

$app->get('/tirajes/createform', '\Sigmalibre\TirajeFactura\TirajesController:indexNew')->setName('tirajes/createform');

// AJUSTES DE USUARIO
$app->get('/ajustes', '\Sigmalibre\UserConfig\UserConfigController:index')->setName('ajustes');

// IVA
$app->get('/iva', '\Sigmalibre\IVA\IVAController:index')->setName('iva');
$app->post('/iva', '\Sigmalibre\IVA\IVAController:update');