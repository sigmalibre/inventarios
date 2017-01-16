<?php

namespace Sigmalibre\Products;

use Psr\Http\Message\ResponseInterface;
use Sigmalibre\Products\DataSource\MySQL\FilterDescuentos;
use Sigmalibre\Products\DataSource\MySQL\SaveNewDescuento;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Controlador para operaciones sobre descuentos de producto.
 */
class DescuentosController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Controlador para crear nuevos descuentos de producto.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                                     $arguments
     *
     * @return Response
     */
    public function createNew(Request $request, ResponseInterface $response, $arguments)
    {
        $producto = new Product($arguments['id'], $this->container);

        if ($producto->is_set() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        $validatorDescuentos = new ValidadorDescuentos();
        $descuentos = new Descuentos($producto, new SaveNewDescuento($this->container), new FilterDescuentos($this->container), $validatorDescuentos);

        $isSaved = $descuentos->crearDescuento($request->getParsedBody());
        return (new ProductsController($this->container))->indexProduct($request, $response, $arguments, $isSaved, $validatorDescuentos->getInvalidInputs());
    }
}