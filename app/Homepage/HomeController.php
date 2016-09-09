<?php
namespace Sigmalibre\Homepage;

/**
 * Controlador para la Homepage, muestra la página de inicio de la aplicación.
 */
class HomeController extends \Sigmalibre\Controller\Controller
{
    /**
     * Método home es llamado automáticamente por Slim, ya que está definido en las rutas.
     * @return Response Retorna una respuesta conteniendo la vista de la homepage.
     */
    public function home($request, $response)
    {
        return $this->view->render($response, 'homepage.html');
    }
}
