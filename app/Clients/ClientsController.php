<?php

namespace Sigmalibre\Clients;

class ClientsController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function indexClients($request, $response)
    {
        $parameters = $request->getQueryParams();

        $clients = new Clients($this->container, $parameters);
        $clientList = $clients->readClientList();

        return $this->container->view->render($response, 'clients.html', [
            'clients' => $clientList['itemList'],
            'pagination' => $clientList['pagination'],
            'input' => $clientList['userInput'],
        ]);
    }
}
