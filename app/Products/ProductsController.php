<?php
namespace Sigmalibre\Products;

/**
 * Controlador para las operaciones sobre productos.
 */
class ProductsController extends \Sigmalibre\Controller\Controller
{
    /**
     * Responde con la vista de la página de búsqueda de productos.
     * @param  object $request HTTP request.
     * @param  object $response HTTP response.
     * @return object HTTP Response conteniendo el html de la página de búsquedas.
     */
    public function getSearchProductsPage($request, $response)
    {
        return $this->view->render($response, 'products.html');
    }
}
