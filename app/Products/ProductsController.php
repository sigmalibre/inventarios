<?php

namespace Sigmalibre\Products;

/**
 * Controlador para las operaciones sobre productos.
 */
class ProductsController
{
    private $container;

    /**
     * Slim pasa el contenedor de dependencias a los controladores de rutas.
     *
     * @param \Slim\Container $container El contenedor de dependencias
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Responde la lista de productos según los términos de búsqueda.
     *
     * @param object $request  HTTP request
     * @param object $response HTTP response
     *
     * @return object HTTP Response conteniendo el resultado de las búsquedas.
     */
    public function indexProducts($request, $response)
    {
        $parameters = $request->getQueryParams();

        $products = new Products($this->container, $parameters);
        $productList = $products->readProductList();

        return $this->container->view->render($response, 'products.html', [
            'products' => $productList['productList'],
            'pagination' => $productList['pagination'],
            'input' => $productList['userInput'],
        ]);
    }
}
