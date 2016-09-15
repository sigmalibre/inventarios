<?php

$app->get('/', '\Sigmalibre\Homepage\HomeController:home')->setName('homepage');

$app->get('/productos', '\Sigmalibre\Products\ProductsController:getProductList')->setName('products');
