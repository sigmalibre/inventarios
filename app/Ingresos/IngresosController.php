<?php

namespace Sigmalibre\Ingresos;
use Psr\Http\Message\ResponseInterface;
use Sigmalibre\Products\ProductsController;
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
        $ingresos = new Ingresos($this->container);

        $productsController = new ProductsController($this->container);

        $isSaved = $ingresos->save($request->getParsedBody(), $arguments['id']);

        return $productsController->indexProduct($request, $response, $arguments, $isSaved, $ingresos->getInvalidInputs());
    }
}