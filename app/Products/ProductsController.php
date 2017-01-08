<?php

namespace Sigmalibre\Products;

use Sigmalibre\IVA\IVA;
use Sigmalibre\Warehouses\WarehouseDetail;
use Sigmalibre\Warehouses\Warehouses;

/**
 * Controlador para las operaciones sobre productos.
 */
class ProductsController
{
    private $container;
    private $products;

    /**
     * Slim pasa el contenedor de dependencias a los controladores de rutas.
     *
     * @param \Slim\Container $container El contenedor de dependencias
     */
    public function __construct($container)
    {
        $this->container = $container;
        $this->products = new Products($container);
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
        $productList = $this->products->readProductList($request->getQueryParams());

        $categories = new \Sigmalibre\Categories\Categories($this->container);

        $brands = new \Sigmalibre\Brands\Brands($this->container);

        $iva = new IVA();

        return $this->container->view->render($response, 'products/products.twig', [
            'products' => $productList['itemList'],
            'pagination' => $productList['pagination'],
            'input' => $productList['userInput'],
            'categories' => $categories->readAllCategories(),
            'brands' => $brands->readAllBrands(),
            'porcentajeIVA' => $iva->getPorcentajeIVA() ?? 0,
        ]);
    }

    /**
     * Renderiza la vista del formulario para crear un nuevo producto.
     * @param  object $request      HTTP Request
     * @param  object $response     HTTP Response
     * @param  array $arguments    Argumentos en la URL obtenidos desde Slim
     * @param  bool $productSaved Sirve para dar feedback al usario sobre la creación de un producto nuevo.
     * @param  array $failedInputs Lista con los inputs que no pasaron la validación para crear un nuevo producto, y así dar mejor feedback al usuario.
     * @return object HTTP Response con la vista renderizada
     */
    public function indexNewProduct($request, $response, $arguments, $productSaved = null, $failedInputs = null)
    {
        $categories = new \Sigmalibre\Categories\Categories($this->container);

        $brands = new \Sigmalibre\Brands\Brands($this->container);

        $unitsOfMeasurement = new \Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurement($this->container);

        $detCategories = new \Sigmalibre\DETCategories\DETCategories($this->container);

        $detReferences = new \Sigmalibre\DETReferences\DETReferences($this->container);

        return $this->container->view->render($response, 'products/newproduct.twig', [
            'categories' => $categories->readAllCategories(),
            'brands' => $brands->readAllBrands(),
            'measurements' => $unitsOfMeasurement->readAllUnitsOfMeasurement(),
            'detcategories' => $detCategories->readAllDETCategories(),
            'detreferences' => $detReferences->readAllDETReferences(),
            'productSaved' => $productSaved,
            'failedInputs' => $failedInputs,
            'input' => $request->getParsedBody(),
        ]);
    }

    /**
     * Realiza la misma función que ProductsController::indexNewProduct,
     * pero en lugar de mostrar el formulario vacío, muestra la información
     * de un producto especificado por la ID en la URL.
     * @see ProductsController:indexNewProduct() Para ver la documentacion sobre este método
     */
    public function indexProduct($request, $response, $arguments, $productSaved = null, $failedInputs = null)
    {
        $product = new Product($arguments['id'], $this->container);

        if ($product->is_set() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        $categories = new \Sigmalibre\Categories\Categories($this->container);

        $brands = new \Sigmalibre\Brands\Brands($this->container);

        $unitsOfMeasurement = new \Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurement($this->container);

        $detCategories = new \Sigmalibre\DETCategories\DETCategories($this->container);

        $detReferences = new \Sigmalibre\DETReferences\DETReferences($this->container);

        $iva = new IVA();

        $warehouses = new Warehouses($this->container);
        $warehouseDetails = new WarehouseDetail($this->container);

        return $this->container->view->render($response, 'products/modifyproduct.twig', [
            'productID' => $arguments['id'],
            'categories' => $categories->readAllCategories(),
            'brands' => $brands->readAllBrands(),
            'measurements' => $unitsOfMeasurement->readAllUnitsOfMeasurement(),
            'detcategories' => $detCategories->readAllDETCategories(),
            'detreferences' => $detReferences->readAllDETReferences(),
            'productSaved' => $productSaved,
            'failedInputs' => $failedInputs,
            'porcentajeIVA' => $iva->getPorcentajeIVA(),
            'cantidadActual' => $product->Cantidad,
            'almacenes' => $warehouses->readAll(),
            'existencia' => $warehouseDetails->readList(['productoID' => $arguments['id']])['itemList'],
            'input' => [
                'categoriaProducto' => $product->CategoriaProductoID,
                'codigoProducto' => $product->CodigoProducto,
                'descripcionProducto' => $product->Descripcion,
                'stockMinProducto' => $product->StockMin,
                'utilidadProducto' => $product->Utilidad,
                'valorCostoActualTotal' => $product->CostoActual,
                'marcaProducto' => $product->NombreMarca,
                'medidaProducto' => $product->UnidadMedida,
                'categoriaDetProducto' => $product->CodigoBienDet,
                'referenciaLibroDetProducto' => $product->CodigoLibroDet,
                'excentoIvaProducto' => $product->ExcentoIVA,
            ],
        ]);
    }

    /**
     * Recibe el input del usuario con la información necesaria para crear un nuevo producto.
     * @param  object $request  HTTP Request
     * @param  object $response HTTP Response
     * @return object HTTP Response con la vista renderizada del formulario de nuevo producto.
     */
    public function createNew($request, $response)
    {
        $brands = new \Sigmalibre\Brands\Brands($this->container);

        $unitsOfMeasurement = new \Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurement($this->container);

        $isProductSaved = $this->products->save($request->getParsedBody(), $brands, $unitsOfMeasurement);

        return $this->indexNewProduct($request, $response, null, $isProductSaved, $this->products->getInvalidInputs());
    }

    /**
     * Actualiza un producto según el input con la información necesaria para realizar dicha operación.
     * @param  object $request   HTTP Request
     * @param  object $response  HTTP Response
     * @param  array $arguments Contiene la ID especificada en la URL.
     * @return object HTTP Response con la vista renderizada del formulario de modificar un producto.
     */
    public function update($request, $response, $arguments)
    {
        $brands = new \Sigmalibre\Brands\Brands($this->container);

        $unitsOfMeasurement = new \Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurement($this->container);

        $product = new Product($arguments['id'], $this->container);

        // Si el producto especificado en la URL no exsiste, devolver un 404.
        if ($product->is_set() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        $isProductUpdated = $product->update($request->getParsedBody(), $brands, $unitsOfMeasurement);

        return $this->indexProduct($request, $response, $arguments, $isProductUpdated, $product->getInvalidInputs());
    }
}
