<?php

namespace Sigmalibre\Clients;

/**
 * Modelo para las operaciones CRUD sobre los clientes.
 */
class Clients
{
    private $container;
    private $userInput;
    private $listReader;

    public function __construct($container, $userInput)
    {
        $this->container = $container;
        $this->userInput = $userInput;
        $this->listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountAllFilteredClients($container),
            new DataSource\MySQL\FilterAllClients($container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );
    }

    public function readClientList()
    {
        $clientList = $this->listReader->read();
        $clientList['userInput'] = $this->userInput;

        return $clientList;
    }
}
