<?php

// HOMEPAGE
$app->get('/', '\Sigmalibre\Homepage\HomeController:home')->setName('homepage');

// PRODUCTOS
$app->get('/productos', '\Sigmalibre\Products\ProductsController:indexProducts')->setName('products');
$app->post('/productos', '\Sigmalibre\Products\ProductsController:createNew');

$app->get('/productos/id/{id}', '\Sigmalibre\Products\ProductsController:indexProduct');
$app->post('/productos/id/{id}', '\Sigmalibre\Products\ProductsController:update');

$app->get('/productos/createform', '\Sigmalibre\Products\ProductsController:indexNewProduct')->setName('products/createform');

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

// UNIDADES DE MEDIDA
$app->get('/medidas', '\Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurementController:indexMeasurements')->setName('measurements');
