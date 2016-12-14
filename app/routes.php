<?php

$app->get('/', '\Sigmalibre\Homepage\HomeController:home')->setName('homepage');

$app->get('/productos', '\Sigmalibre\Products\ProductsController:indexProducts')->setName('products');
$app->post('/productos', '\Sigmalibre\Products\ProductsController:createNew');

$app->get('/productos/id/{id}', '\Sigmalibre\Products\ProductsController:indexProduct');

$app->get('/productos/createform', '\Sigmalibre\Products\ProductsController:indexNewProduct')->setName('products/createform');

$app->get('/categorias', '\Sigmalibre\Categories\CategoriesController:indexCategories')->setName('categories');
$app->post('/categorias', '\Sigmalibre\Categories\CategoriesController:createNew');

$app->get('/categorias/createform', '\Sigmalibre\Categories\CategoriesController:indexNewCategory')->setName('categories/createform');

$app->get('/proveedores', '\Sigmalibre\Providers\ProvidersController:indexProviders')->setName('providers');

$app->get('/facturas', '\Sigmalibre\Invoices\InvoicesController:indexInvoices')->setName('invoices');

$app->get('/creditofiscal', '\Sigmalibre\Invoices\InvoicesController:indexCreditoFiscal')->setName('creditofiscal');

$app->get('/warehouses', '\Sigmalibre\Warehouses\WarehousesController:indexWarehouses')->setName('warehouses');

$app->get('/clientes/personas', '\Sigmalibre\Clients\ClientsController:indexPeople')->setName('clientes/personas');
$app->get('/clientes/empresas', '\Sigmalibre\Clients\ClientsController:indexCompanies')->setName('clientes/empresas');

$app->get('/marcas', '\Sigmalibre\Brands\BrandsController:indexBrands')->setName('brands');

$app->get('/medidas', '\Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurementController:indexMeasurements')->setName('measurements');
