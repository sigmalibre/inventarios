<?php

namespace Sigmalibre\Clients;

/**
 * Controlador para las acciones sobre los clientes.
 */
class ClientsController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Responde con la vista de la lista de clientes personas.
     *
     * @param object $request  HTTP Request
     * @param object $response HTTP Response
     *
     * @return object HTTP Response con la vista de la lista de clientes personas
     */
    public function indexPeople($request, $response)
    {
        $clients = new Clients($this->container);
        $clientList = $clients->readPeopleList($request->getQueryParams());

        return $this->container->view->render($response, 'clients/clientepersona.twig', [
            'clients' => $clientList['itemList'],
            'pagination' => $clientList['pagination'],
            'input' => $clientList['userInput'],
        ]);
    }

    /**
     * Responde con la vista de la lista de clientes contribuyentes.
     *
     * @param object $request  HTTP Request
     * @param object $response HTTP Response
     *
     * @return object HTTP Response con la vista de la lista de clientes empresas
     */
    public function indexCompanies($request, $response)
    {
        $clients = new Clients($this->container);
        $clientList = $clients->readCompanyList($request->getQueryParams());

        return $this->container->view->render($response, 'clients/clienteempresa.twig', [
            'clients' => $clientList['itemList'],
            'pagination' => $clientList['pagination'],
            'input' => $clientList['userInput'],
        ]);
    }
}
