<?php

namespace Sigmalibre\Ingresos;
use Psr\Http\Message\ResponseInterface;
use Sigmalibre\Products\ProductsController;
use Sigmalibre\Warehouses\Warehouses;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Controlador para manejo de entradas de producto.
 */
class IngresosController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Renderiza la vista con la lista de los detalles entrada de producto
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return Response
     */
    public function indexAll(Request $request, ResponseInterface $response)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $almacenes = new Warehouses($this->container);
        $categories = new \Sigmalibre\Categories\Categories($this->container);
        $brands = new \Sigmalibre\Brands\Brands($this->container);

        $ingresos = new Ingresos($this->container);
        $result = $ingresos->readList($request->getQueryParams());

        return $this->container->view->render($response, 'ingresos/ingresos.twig', [
            'ingresos' => $result['itemList'],
            'almacenes' => $almacenes->readAll(),
            'categories' => $categories->readAllCategories(),
            'brands' => $brands->readAllBrands(),
            'pagination' => $result['pagination'],
            'input' => $result['userInput'],
        ]);
    }

    /**
     * Registra una nueva entrada de productos.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                                     $arguments
     *
     * @return Response
     */
    public function createNew(Request $request, ResponseInterface $response, $arguments)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $ingresos = new Ingresos($this->container);

        $productsController = new ProductsController($this->container);

        $isSaved = $ingresos->save($request->getParsedBody(), $arguments['id']);

        return $productsController->indexProduct($request, $response, $arguments, $isSaved, $ingresos->getInvalidInputs());
    }

    /**
     * Registra una nueva entrada de productos.
     *
     * Por ajuste de inventario.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                                     $arguments
     *
     * @return Response
     */
    public function ajuste(Request $request, ResponseInterface $response, $arguments)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $ingresos = new Ingresos($this->container);

        $ultimo_ingreso = $ingresos->lastFromProduct($arguments['id']);

        if(!isset($ultimo_ingreso[0])) {
            return (new Response())->withJson([ 'success' => false ], 200);
        }

        $ultimo_ingreso = $ultimo_ingreso[0];

        $isSaved = $ingresos->save([
            'empresaID' => $ultimo_ingreso['EmpresaID'],
            'almacenID' => $ultimo_ingreso['AlmacenID'],
            'cantidadIngreso' => $request->getParsedBody()['ajuste'],
            'valorPrecioUnitario' => $ultimo_ingreso['PrecioUnitario'],
        ], $arguments['id']);

        return (new Response())->withJson([ 'success' => $isSaved ], 200);
    }
}