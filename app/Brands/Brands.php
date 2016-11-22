<?php

namespace Sigmalibre\Brands;

/**
 * Modelo para operaciones CRUD sobre las marcas.
 */
class Brands
{
    private $container;
    private $userInput;
    private $listReader;

    public function __construct($container, $userInput)
    {
        $this->container = $container;
        $this->userInput = $userInput;
        $this->listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountAllFilteredBrands($container),
            new DataSource\MySQL\FilterAllBrands($container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );
    }

    public function readBrandList()
    {
        $brandList = $this->listReader->read();
        $brandList['userInput'] = $this->userInput;

        return $brandList;
    }
}
