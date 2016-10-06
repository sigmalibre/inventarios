<?php

namespace Sigmalibre\Warehouses;

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

    public function indexWarehouses($request, $response)
    {
        $parameters = $request->getQueryParams();

        $warehouses = new Warehouses($this->container, $parameters);
        $warehouseResults = $warehouses->readWarehouseList();

        return $this->container->view->render($response, 'warehouses.html', [
            'warehouses' => $warehouseResults['itemList'],
            'pagination' => $warehouseResults['pagination'],
            'input' => $warehouseResults['userInput'],
        ]);
    }
}
