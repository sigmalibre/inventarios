<?php

namespace Sigmalibre\Warehouses;

/**
 * Modelo para las operaciones CRUD sobre las bodegas.
 */
class Warehouses
{
    private $container;
    private $userInput;
    private $listReader;

    public function __construct($container, $userInput)
    {
        $this->container = $container;
        $this->userInput = $userInput;
        $this->listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountAllFilteredWarehouses($container),
            new DataSource\MySQL\FilterAllWarehouses($container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );
    }

    /**
     * Obtiene la lista con las bodegas existentes según los términos de búsqueda
     * que aplique el usuario y con paginación.
     * @return array
     */
    public function readWarehouseList()
    {
        $warehouseList = $this->listReader->read();
        $warehouseList['userInput'] = $this->userInput;

        return $warehouseList;
    }
}
