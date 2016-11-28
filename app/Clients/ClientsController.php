<?php

namespace Sigmalibre\Clients;

class ClientsController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function indexPeople($request, $response)
    {
        $clients = new Clients($this->container);
        $clientList = $clients->readPeopleList($request->getQueryParams());

        return $this->container->view->render($response, 'clients/clientepersona.html', [
            'clients' => $clientList['itemList'],
            'pagination' => $clientList['pagination'],
            'input' => $clientList['userInput'],
        ]);
    }
}
