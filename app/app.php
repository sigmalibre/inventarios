<?php

use Sigmalibre\Accounts\LogIn\LoggedInCheckMiddleware;

session_start();

// Define la constante APP_ROOT que apunta hacia la dirección absuluta del directorio del proyecto
// Sirve para no tener que confiar en rutas relativas.
define('APP_ROOT', dirname(__DIR__));

require APP_ROOT . '/vendor/autoload.php';

$config = require APP_ROOT . '/app/config/development.php';

$app = new \Slim\App($config);

// CONTENEDOR DE DEPENDENCIAS
require APP_ROOT . '/app/DIC.php';

$app->add(new LoggedInCheckMiddleware());

// RUTAS (URLs)
require APP_ROOT . '/app/routes.php';

$app->run();
