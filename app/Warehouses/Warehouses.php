<?php

namespace Sigmalibre\Warehouses;
use Sigmalibre\ItemList\ItemListReader;
use Sigmalibre\Pagination\Paginator;

/**
 * Modelo para las operaciones CRUD sobre las bodegas.
 */
class Warehouses
{
    private $container;
    private $validator;

    public function __construct($container)
    {
        $this->container = $container;
        $this->validator = new WarehousesValidator();
    }

    /**
     * Obtiene la lista con las bodegas existentes según los términos de búsqueda
     * que aplique el usuario y con paginación.
     *
     * @param $userInput
     *
     * @return array
     */
    public function readWarehouseList($userInput)
    {
        $listReader = new ItemListReader(
            new DataSource\MySQL\CountAllFilteredWarehouses($this->container),
            new DataSource\MySQL\FilterAllWarehouses($this->container),
            new Paginator($userInput),
            $userInput
        );

        $warehouseList = $listReader->read();
        $warehouseList['userInput'] = $this->userInput;

        return $warehouseList;
    }
}
