<?php
namespace Sigmalibre\Products;

/**
 * Controlador para las operaciones sobre productos.
 */
class ProductsController extends \Sigmalibre\Controller\Controller
{
    /**
     * Responde la lista de productos según los términos de búsqueda.
     * @param  object $request HTTP request.
     * @param  object $response HTTP response.
     * @return object HTTP Response conteniendo el resultado de las búsquedas, con formato dependiendo del header Accept.
     */
    public function getProducts($request, $response)
    {
        $parameters = $request->getQueryParams();

        if (empty($parameters) === true) {
            return $this->view->render($response, 'products.html');
        }

        // mapeado desde los inputs del formulario a la lista con los identificadores.
        $identifiers = [
            'codigo' => (empty($parameters['codigoProducto'])) ? '' : $parameters['codigoProducto'],
            'marca' => (empty($parameters['marcaProducto'])) ? '' : $parameters['marcaProducto'],
            'modelo' => (empty($parameters['modeloProducto'])) ? '' : $parameters['modeloProducto'],
            'ubicacion' => (empty($parameters['ubicacionProducto'])) ? '' : $parameters['ubicacionProducto'],
            'descripcion' => (empty($parameters['descripcionProducto'])) ? '' : $parameters['descripcionProducto'],
        ];

        $dataSource = new \Sigmalibre\DataSource\MySQL\ProductsDataSource($this->container);
        $products = new Products($dataSource);
        $product_list = $products->getProducts($identifiers);

        return $this->view->render($response, 'products.html', [
            'products' => $product_list
        ]);
    }
}
