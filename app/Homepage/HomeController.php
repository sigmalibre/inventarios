<?php
namespace Sigmalibre\Homepage;

/**
 * Controlador para la Homepage, muestra la página de inicio de la aplicación.
 */
class HomeController
{
    private $container;

    /**
     * Slim pasa el contenedor de dependencias a los controladores de rutas.
     * @param \Slim\Container $container El contenedor de dependencias.
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Renderiza la vista del homepage.
     * @return Response Retorna una respuesta conteniendo la vista de la homepage.
     */
    public function home($request, $response)
    {
        return $this->container->view->render($response, 'homepage.html');
    }
}
