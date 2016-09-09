<?php

define('APP_ROOT', dirname(__DIR__));

require APP_ROOT . '/vendor/autoload.php';

$config = require APP_ROOT . '/app/config/development.php';

$app = new \Slim\App($config);

// CONTENEDOR DE DEPENDENCIAS
$container = $app->getContainer();

// Agregar las dependencias al contenedor:

$container['view'] = function($container)
{
    // Se utilizará Twig para las vistas.
    $view = new \Slim\Views\Twig(APP_ROOT . '/app/Views', $container->settings['twig']);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    return $view;
};

// RUTAS (URLs)

// Ruta de la homepage
$app->get('/', function ($request, $response) {
    return $this->view->render($response, 'homepage.html');
})->setName('homepage');
$app->run();
