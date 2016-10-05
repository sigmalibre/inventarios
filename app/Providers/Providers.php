<?php

namespace Sigmalibre\Providers;

/**
 * Modelo para operaciones CRUD sobre los proveedores.
 */
class Providers
{
    private $container;
    private $userInput;
    private $listReader;

    public function __construct($container, $userInput)
    {
        $this->container = $container;
        $this->userInput = $userInput;
        $this->listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountAllFilteredProviders($container),
            new DataSource\MySQL\FilterAllProviders($container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );
    }

    /**
     * Obtiene una lista de proveedores según los filtros que aplique el usuario, la lista de proveedores viene paginada.
     *
     * @return array Lista con los proveedores
     */
    public function readProviderList()
    {
        $providerList = $this->listReader->read();
        $providerList['userInput'] = $this->userInput;

        return $providerList;
    }
}
