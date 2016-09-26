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
     * @param \Slim\Container $container El contenedor de dependencias.
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Responde la lista de productos según los términos de búsqueda.
     * @param  object $request HTTP request.
     * @param  object $response HTTP response.
     * @return object HTTP Response conteniendo el resultado de las búsquedas, con formato dependiendo del header Accept.
     */
    public function getProductList($request, $response)
    {
        $parameters = $request->getQueryParams();

        if (empty($parameters) === true) {
            return $this->container->view->render($response, 'products.html');
        }

        $dataSource = new \Sigmalibre\Products\DataSource\MySQLDataSource($this->container);
        $products = new Products($dataSource);
        $product_list = $products->readProductList($parameters);

        return $this->container->view->render($response, 'products.html', [
            'products' => $product_list
        ]);
    }
}
