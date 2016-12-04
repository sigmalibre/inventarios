<?php

define('APP_ROOT', dirname(__DIR__));

require APP_ROOT . '/vendor/autoload.php';

$config = require APP_ROOT . '/app/config/development.php';

$app = new \Slim\App($config);

// CONTENEDOR DE DEPENDENCIAS
$container = $app->getContainer();

// AGREGA LAS DEPENDENCIAS AL CONTENEDOR
// Vistas:
$container['view'] = function($container)
{
    // Se utilizará Twig para las vistas.
    $view = new \Slim\Views\Twig(APP_ROOT . '/app/Views', $container->settings['twig']);

    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    $view->addExtension(new \Twig_Extension_Debug());

    $view->getEnvironment()->addGlobal('uri_path', $container->request->getUri()->getPath());

    return $view;
};

// Content Negotiator:
$container['negotiator'] = function($container)
{
    $acceptHeader = $container->request->getHeaderLine('Accept');
    $priorities = ['text/html; charset=UTF-8', 'application/json'];

    $negotiator = new \Negotiation\Negotiator;

    $mediaType = $negotiator->getBest($acceptHeader, $priorities);

    return $mediaType;
};

// Respect Validator
$container['validator'] = function($container)
{
    return new \Respect\Validation\Validator;
};

// RUTAS (URLs)
require APP_ROOT . '/app/routes.php';

$app->run();
