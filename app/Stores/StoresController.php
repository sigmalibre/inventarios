<?php

namespace Sigmalibre\Stores;

/**
 * Controlador para las operaciones sobre las sucursales.
 */
class StoresController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function indexStores($request, $response)
    {
        $parameters = $request->getQueryParams();

        $stores = new Stores($this->container, $parameters);
        $storesResults = $stores->readStoreList();

        return $this->container->view->render($response, 'stores.html', [
            'stores' => $storesResults['itemList'],
            'pagination' => $storesResults['pagination'],
            'input' => $storesResults['userInput'],
        ]);
    }
}
