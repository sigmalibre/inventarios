<?php
/**
* Dependency Injection Container - Contenedor de dependencias.
*
* En este archivo se declaran todas las dependencias que se guardarán dentro
* del contenedor de dependencias de Slim.
*/

// CONTENEDOR DE DEPENDENCIAS
$container = $app->getContainer();

// Vistas:
$container['view'] = function ($container) {
    // Se utilizará Twig para las vistas.
    $view = new \Slim\Views\Twig(APP_ROOT.'/app/Views', $container->settings['twig']);

    // Se añaden las extensiones para poder utilizar funciones como path_for().
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    // extensión para poder utilizar la función dump()
    $view->addExtension(new \Twig_Extension_Debug());

    // se agrega esta global a todas las vistas para obtener la ruta después del directorio web root
    // Ej: si la url completa es http://inventarios.com/productos/id/15
    // uri_path devueve /productos/id/15
    $view->getEnvironment()->addGlobal('uri_path', $container->request->getUri()->getPath());

    // AGREGAR SI ES ADMIN A LAS VISTAS PARA OCULTAR SEGÚN TIPO DE CUENTA
    $view->getEnvironment()->addGlobal('is_admin', ($_SESSION['username'] ?? '') === 'admin');

    return $view;
};

// Content Negotiator:
// Por ahora no se está utilizando, pero será util en el futuro si decidimos devolver json en lugar de html por ejemplo.
// Aunque probablemente eso no llegue a pasar...
$container['negotiator'] = function ($container) {
    $acceptHeader = $container->request->getHeaderLine('Accept');
    $priorities = ['text/html; charset=UTF-8', 'application/json'];

    $negotiator = new \Negotiation\Negotiator();

    $mediaType = $negotiator->getBest($acceptHeader, $priorities);

    return $mediaType;
};

// Respect Validator
// Se utiliza para facilitar la validación de inputs, por ejemplo al crear nuevos productos o editar categorías.
$container['validator'] = function ($container) {
    return new \Respect\Validation\Validator();
};

// Conexión a MySQL
// Instancia única de la clase MySQL para imitar el patrón Singleton.
$mysqlSingletonInstance = new \Sigmalibre\DataSource\MySQL\MySQLTransactions($container);

$container['mysql'] = function ($container) use ($mysqlSingletonInstance) {
    return $mysqlSingletonInstance;
};
