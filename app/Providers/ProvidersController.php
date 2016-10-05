<?php

namespace Sigmalibre\Providers;

/**
 * Controlador para las operaciones sobre proveedores.
 */
class ProvidersController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Retorna una página HTML con la lista de los proveedores y campos de búsqueda.
     */
    public function indexProviders($request, $response)
    {
        $parameters = $request->getQueryParams();

        $providers = new Providers($this->container, $parameters);
        $providerResult = $providers->readProviderList();

        return $this->container->view->render($response, 'providers.html', [
            'providers' => $providerResult['itemList'],
            'pagination' => $providerResult['pagination'],
            'input' => $providerResult['userInput'],
        ]);
    }
}
