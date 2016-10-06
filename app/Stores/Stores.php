<?php

namespace Sigmalibre\Stores;

/**
 * Modelo para las operaciones CRUD sobre las sucursales.
 */
class Stores
{
    private $container;
    private $userInput;
    private $listReader;

    public function __construct($container, $userInput)
    {
        $this->container = $container;
        $this->userInput = $userInput;
        $this->listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountAllFilteredStores($container),
            new DataSource\MySQL\FilterAllStores($container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );
    }

    public function readStoreList()
    {
        $storeList = $this->listReader->read();
        $storeList['userInput'] = $this->userInput;

        return $storeList;
    }
}
