<?php

$app->get('/', '\Sigmalibre\Homepage\HomeController:home')->setName('homepage');

$app->get('/productos', '\Sigmalibre\Products\ProductsController:indexProducts')->setName('products');

$app->get('/categorias', '\Sigmalibre\Categories\CategoriesController:indexCategories')->setName('categories');

$app->get('/proveedores', '\Sigmalibre\Providers\ProvidersController:indexProviders')->setName('providers');

$app->get('/facturas', '\Sigmalibre\Invoices\InvoicesController:indexInvoices')->setName('invoices');

$app->get('/warehouses', '\Sigmalibre\Warehouses\WarehousesController:indexWarehouses')->setName('warehouses');

$app->get('/sucursales', '\Sigmalibre\Stores\StoresController:indexStores')->setName('stores');

$app->get('/clientes', '\Sigmalibre\Clients\ClientsController:indexClients')->setName('clients');
