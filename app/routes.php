<?php

$app->get('/', '\Sigmalibre\Homepage\HomeController:home')->setName('homepage');

$app->get('/productos', '\Sigmalibre\Products\ProductsController:indexProducts')->setName('products');

$app->get('/categorias', '\Sigmalibre\Categories\CategoriesController:indexCategories')->setName('categories');
