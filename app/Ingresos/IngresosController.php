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

        $ingresos = new Ingresos($this->container);
        $result = $ingresos->readList($request->getQueryParams());

        return $this->container->view->render($response, 'ingresos/ingresos.twig', [
            'ingresos' => $result['itemList'],
            'almacenes' => $almacenes->readAll(),
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
}