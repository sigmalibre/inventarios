<?php

namespace Sigmalibre\Clients;

/**
 * Modelo para las operaciones CRUD sobre los clientes.
 */
class Clients
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function readPeopleList($userInput)
    {
        $listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountFilteredClientePersona($this->container),
            new DataSource\MySQL\FilterClientePersona($this->container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );

        $clientList = $listReader->read();
        $clientList['userInput'] = $userInput;

        return $clientList;
    }

    public function readCompanyList($userInput)
    {
        $listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountFilteredClienteEmpresa($this->container),
            new DataSource\MySQL\FilterClienteEmpresa($this->container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );

        $clientList = $listReader->read();
        $clientList['userInput'] = $userInput;

        return $clientList;
    }
}
