<?php

namespace Sigmalibre\Products;

use Psr\Http\Message\ResponseInterface;
use Sigmalibre\Products\DataSource\MySQL\DeleteDescuento;
use Sigmalibre\Products\DataSource\MySQL\FilterDescuentos;
use Sigmalibre\Products\DataSource\MySQL\SaveNewDescuento;
use Sigmalibre\Products\DataSource\MySQL\UpdateDescuento;
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
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $producto = new Product($arguments['id'], $this->container);

        if ($producto->is_set() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        $validatorDescuentos = new ValidadorDescuentos();
        $descuentos = new Descuentos($producto, new FilterDescuentos($this->container), $validatorDescuentos);

        $isSaved = $descuentos->escribirDescuento($request->getParsedBody(), new SaveNewDescuento($this->container));

        return (new ProductsController($this->container))->indexProduct($request, $response, $arguments, $isSaved, $validatorDescuentos->getInvalidInputs());
    }

    /**
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                                     $arguments
     * @param null                                $isSaved
     * @param null                                $failedInputs
     *
     * @return Response
     */
    public function indexDescuento(Request $request, ResponseInterface $response, $arguments, $isSaved = null, $failedInputs = null)
    {
        $validatorDescuentos = new ValidadorDescuentos();

        $producto = new Product($arguments['productoID'], $this->container);
        if ($producto->is_set() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        $descuentos = new Descuentos($producto, new FilterDescuentos($this->container), $validatorDescuentos);

        $datosDescuento = $descuentos->getSingle($arguments['descuentoID']);
        if (isset($datosDescuento[0]) === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        $datosDescuento = $datosDescuento[0];

        return $this->container->view->render($response, 'products/modificardescuento.twig', [
            'productoID' => $arguments['productoID'],
            'descuentoID' => $arguments['descuentoID'],
            'isSaved' => $isSaved,
            'failedInputs' => $failedInputs,
            'input' => [
                'razonDescuento' => $datosDescuento['RazonDescuento'],
                'cantidadDescontada' => $datosDescuento['CantidadDescontada'],
                'utilidadProducto' => $producto->Utilidad,
            ],
        ]);
    }

    /**
     * Actualiza los datos de un descuento de producto.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                                     $arguments
     *
     * @return \Slim\Http\Response
     */
    public function update(Request $request, ResponseInterface $response, $arguments)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $validatorDescuentos = new ValidadorDescuentos();
        $descuentos = new Descuentos(new Product($arguments['productoID'], $this->container), new FilterDescuentos($this->container), $validatorDescuentos);

        $input = $request->getParsedBody();
        $input['descuentoID'] = $arguments['descuentoID'];

        $isUpdated = $descuentos->escribirDescuento($input, new UpdateDescuento($this->container));

        return $this->indexDescuento($request, $response, $arguments, $isUpdated, $validatorDescuentos->getInvalidInputs());
    }

    /**
     * Elimina un registro de un descuento de producto.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                                     $arguments
     *
     * @return \Slim\Http\Response
     */
    public function delete(Request $request, ResponseInterface $response, $arguments)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $descuentos = new Descuentos(new Product($arguments['productoID'], $this->container), new FilterDescuentos($this->container), new ValidadorDescuentos());

        $isDeleted = $descuentos->eliminar($arguments['descuentoID'], new DeleteDescuento($this->container));

        return (new Response())->withJson([
            'status' => $isDeleted ? 'success' : 'error',
        ], $isDeleted ? 200 : 500);
    }

    /**
     * Obtiene la lista de los descuentos aplicables a un producto
     *
     * @param $request
     * @param $response
     * @param $arguments
     *
     * @return \Slim\Http\Response
     */
    public function getDescuentosProducto($request, $response, $arguments)
    {
        $producto = new Product($arguments['id'], $this->container);

        $descuentos = new Descuentos($producto, new FilterDescuentos($this->container), new ValidadorDescuentos());

        return (new Response())->withJson($descuentos->getDescuentos(), 200);
    }
}