<?php

namespace Sigmalibre\Warehouses;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Controlador para las operaciones sobre las bodegas.
 */
class WarehousesController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Renderiza la vista que muestra la lista de las bodegas existentes
     * @param  object $request  HTTP Request
     * @param  object $response HTTP Response
     * @return object HTTP Response con la vista renderizada
     */
    public function indexWarehouses($request, $response)
    {
        $parameters = $request->getQueryParams();

        $warehouses = new Warehouses($this->container);
        $warehouseResults = $warehouses->readWarehouseList($parameters);

        return $this->container->view->render($response, 'warehouses/warehouses.twig', [
            'warehouses' => $warehouseResults['itemList'],
            'pagination' => $warehouseResults['pagination'],
            'input' => $warehouseResults['userInput'],
        ]);
    }

    /**
     * Renderiza la vista del formulario de creación de un nuevo almacén.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                                     $arguments
     * @param null                                $isSaved
     * @param null                                $failedInputs
     *
     * @return Response
     */
    public function indexCreateWarehouse(Request $request, ResponseInterface $response, $arguments, $isSaved = null, $failedInputs = null)
    {
        return $this->container->view->render($response, 'warehouses/newwarehouse.twig', [
            'isSaved' => $isSaved,
            'failedInputs' => $failedInputs,
            'input' => $request->getParsedBody(),
        ]);
    }

    /**
     * Recibe el input del usuario para crear un nuevo almacén.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Slim\Http\Response
     */
    public function createNew(Request $request, ResponseInterface $response)
    {
        $warehouses = new Warehouses($this->container);

        $isSaved = $warehouses->save($request->getParsedBody());

        return $this->indexCreateWarehouse($request, $response, null, $isSaved, $warehouses->getInvalidInputs());
    }

    /**
     * Renderiza la vista mostrando los detalles de un almacén.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                                     $arguments
     * @param null                                $isSaved
     * @param null                                $failedInputs
     *
     * @return Response
     */
    public function indexWarehouse(Request $request, ResponseInterface $response, $arguments, $isSaved = null, $failedInputs = null)
    {
        $warehouse = new Warehouse($arguments['id'], $this->container);

        if ($warehouse->is_set() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        return $this->container->view->render($response, 'warehouses/updatewarehouse.twig', [
            'almacenID' => $arguments['id'],
            'isSaved' => $isSaved,
            'failedInputs' => $failedInputs,
            'input' => [
                'nombreAlmacen' => $warehouse->getNombre(),
                'direccion' => $warehouse->getDireccion(),
                'telefono' => $warehouse->getTelefono(),
            ],
        ]);
    }

    /**
     * Actualiza la información sobre un almacén.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                                     $arguments
     *
     * @return \Slim\Http\Response
     */
    public function update(Request $request, ResponseInterface $response, $arguments)
    {
        $warehouse = new Warehouse($arguments['id'], $this->container);

        if ($warehouse->is_set() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        $isSaved = $warehouse->update($request->getParsedBody());

        return $this->indexWarehouse($request, $response, $arguments, $isSaved, $warehouse->getInvalidInputs());
    }
}
