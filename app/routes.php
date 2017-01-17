<?php

// HOMEPAGE
$app->get('/', '\Sigmalibre\Homepage\HomeController:home')->setName('homepage');

// PRODUCTOS
$app->get('/productos', '\Sigmalibre\Products\ProductsController:indexProducts')->setName('products');

$app->get('/productos/id/{id}', '\Sigmalibre\Products\ProductsController:indexProduct')->setName('products/update');
$app->post('/productos/id/{id}', '\Sigmalibre\Products\ProductsController:update');

$app->post('/productos/id/{id}/ingresos', '\Sigmalibre\Ingresos\IngresosController:createNew')->setName('products/ingresos');
$app->post('/productos/id/{id}/traslados', '\Sigmalibre\Products\ProductsController:traslado')->setName('products/traslado');
$app->post('/productos/id/{id}/descuentos', '\Sigmalibre\Products\DescuentosController:createNew')->setName('products/descuentos');

$app->get('/productos/id/{productoID}/descuentos/id/{descuentoID}', '\Sigmalibre\Products\DescuentosController:indexDescuento')->setName('products/descuentos/modify');
$app->post('/productos/id/{productoID}/descuentos/id/{descuentoID}', '\Sigmalibre\Products\DescuentosController:update');

$app->get('/productos/nuevo', '\Sigmalibre\Products\ProductsController:indexNewProduct')->setName('products/createform');
$app->post('/productos/nuevo', '\Sigmalibre\Products\ProductsController:createNew');

$app->get('/productos/importar', '\Sigmalibre\Products\ImportarController:importar')->setName('importar');

$app->get('/productos/ingresos', '\Sigmalibre\Ingresos\IngresosController:indexAll')->setName('ingresos');


// CATEGORIAS DE PRODUCTO
$app->get('/categorias', '\Sigmalibre\Categories\CategoriesController:indexCategories')->setName('categories');

$app->get('/categorias/id/{id}', '\Sigmalibre\Categories\CategoriesController:indexCategory')->setName('categories/update');
$app->post('/categorias/id/{id}', '\Sigmalibre\Categories\CategoriesController:update');

$app->get('/categorias/nuevo', '\Sigmalibre\Categories\CategoriesController:indexNewCategory')->setName('categories/createform');
$app->post('/categorias/nuevo', '\Sigmalibre\Categories\CategoriesController:createNew');

// PROVEEDORES
$app->get('/contactos/proveedores', '\Sigmalibre\Providers\ProvidersController:indexProviders')->setName('providers');

// FACTURACIÓN
$app->get('/facturas', '\Sigmalibre\Invoices\InvoicesController:indexInvoices')->setName('invoices');

$app->get('/creditofiscal', '\Sigmalibre\Invoices\InvoicesController:indexCreditoFiscal')->setName('creditofiscal');

// ALMACENES
$app->get('/almacenes', '\Sigmalibre\Warehouses\WarehousesController:indexWarehouses')->setName('warehouses');

$app->get('/almacenes/id/{id}', '\Sigmalibre\Warehouses\WarehousesController:indexWarehouse')->setName('warehouses/update');
$app->post('/almacenes/id/{id}', '\Sigmalibre\Warehouses\WarehousesController:update');

$app->get('/almacenes/nuevo', '\Sigmalibre\Warehouses\WarehousesController:indexCreateWarehouse')->setName('warehouses/createform');
$app->post('/almacenes/nuevo', '\Sigmalibre\Warehouses\WarehousesController:createNew');

// CLIENTES
$app->get('/contactos/clientes/personas', '\Sigmalibre\Clients\ClientsController:indexPeople')->setName('clientes/personas');

$app->get('/contactos/clientes/personas/nuevo', '\Sigmalibre\Clients\ClientsController:indexNew')->setName('clientes/createform');
$app->post('/contactos/clientes/personas/nuevo', '\Sigmalibre\Clients\ClientsController:createNew');

$app->get('/contactos/clientes/personas/id/{id}', '\Sigmalibre\Clients\ClientsController:indexCliente')->setName('clientes/update');
$app->post('/contactos/clientes/personas/id/{id}', '\Sigmalibre\Clients\ClientsController:update');

$app->get('/contactos/clientes/empresas', '\Sigmalibre\Clients\ClientsController:indexCompanies')->setName('clientes/empresas');

// MARCAS
$app->get('/marcas', '\Sigmalibre\Brands\BrandsController:indexBrands')->setName('brands');

$app->get('/marcas/id/{id}', '\Sigmalibre\Brands\BrandsController:indexBrand')->setName('brands/update');
$app->post('/marcas/id/{id}', '\Sigmalibre\Brands\BrandsController:update');

// UNIDADES DE MEDIDA
$app->get('/medidas', '\Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurementController:indexMeasurements')->setName('measurements');

$app->get('/medidas/id/{id}', '\Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurementController:indexUnit')->setName('measurements/update');
$app->post('/medidas/id/{id}', '\Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurementController:update');

// TIRAJE FACTURAS
$app->get('/tirajes', '\Sigmalibre\TirajeFactura\TirajesController:indexListaTirajes')->setName('tirajes');

$app->get('/tirajes/id/{id}', '\Sigmalibre\TirajeFactura\TirajesController:indexTiraje')->setName('tirajes/update');
$app->post('/tirajes/id/{id}', '\Sigmalibre\TirajeFactura\TirajesController:update');

$app->get('/tirajes/nuevo', '\Sigmalibre\TirajeFactura\TirajesController:indexNew')->setName('tirajes/createform');
$app->post('/tirajes/nuevo', '\Sigmalibre\TirajeFactura\TirajesController:createNew');

// AJUSTES DE USUARIO
$app->get('/ajustes', '\Sigmalibre\UserConfig\UserConfigController:index')->setName('ajustes');

// IVA
$app->get('/iva', '\Sigmalibre\IVA\IVAController:index')->setName('iva');
$app->post('/iva', '\Sigmalibre\IVA\IVAController:update');

// CONTACTOS
$app->get('/contactos/empresas', '\Sigmalibre\Empresas\EmpresasController:indexEmpresas')->setName('empresas');

$app->get('/contactos/empresas/nuevo', '\Sigmalibre\Empresas\EmpresasController:indexNew')->setName('empresas/createform');
$app->post('/contactos/empresas/nuevo', '\Sigmalibre\Empresas\EmpresasController:createNew');

$app->get('/contactos/empresas/id/{id}', '\Sigmalibre\Empresas\EmpresasController:indexEmpresa')->setName('empresa');
$app->post('/contactos/empresas/id/{id}', '\Sigmalibre\Empresas\EmpresasController:update');
