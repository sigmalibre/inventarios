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

    /**
     * Obtiene la lista con todas las personas clientes de la empresa
     * según los términos de búsqueda y la pagínación.
     *
     * @param array $userInput Input del usuario con los filtros para la búsqueda
     *
     * @return array Lista con los clientes encontrados
     */
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

    /**
     * Obtiene la lista con todas las empresas contribuyentes
     * según los términos de búsqueda y la pagínación.
     *
     * @param array $userInput Input del usuario con los filtros para la búsqueda
     *
     * @return array Lista con los clientes encontrados
     */
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
