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
        $products = new Products($this->container);
        $productList = $products->readProductList($request->getQueryParams());

        $categories = new \Sigmalibre\Categories\Categories($this->container);

        $brands = new \Sigmalibre\Brands\Brands($this->container);

        return $this->container->view->render($response, 'products/products.html', [
            'products' => $productList['itemList'],
            'pagination' => $productList['pagination'],
            'input' => $productList['userInput'],
            'categories' => $categories->readAllCategories(),
            'brands' => $brands->readAllBrands(),
        ]);
    }

    public function indexNewProduct($request, $response)
    {
        $categories = new \Sigmalibre\Categories\Categories($this->container);

        $brands = new \Sigmalibre\Brands\Brands($this->container);

        $unitsOfMeasurement = new \Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurement($this->container);

        $detCategories = new \Sigmalibre\DETCategories\DETCategories($this->container);

        $detReferences = new \Sigmalibre\DETReferences\DETReferences($this->container);

        return $this->container->view->render($response, 'products/newproduct.html', [
            'categories' => $categories->readAllCategories(),
            'brands' => $brands->readAllBrands(),
            'measurements' => $unitsOfMeasurement->readAllUnitsOfMeasurement(),
            'detcategories' => $detCategories->readAllDETCategories(),
            'detreferences' => $detReferences->readAllDETReferences(),
        ]);
    }
}
