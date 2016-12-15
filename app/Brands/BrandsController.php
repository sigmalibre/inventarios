<?php

namespace Sigmalibre\Brands;

/**
 * Controlador para las operaciones sobre marcas.
 */
class BrandsController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Responde con la vista de la lista de todas las marcas.
     *
     * @param object $request  HTTP Request
     * @param object $response HTTP Response
     *
     * @return object HTTP Response con la vista de la lista de las marcas en el cuerpo
     */
    public function indexBrands($request, $response)
    {
        $brands = new Brands($this->container);
        $brandResult = $brands->readBrandList($request->getQueryParams());

        return $this->container->view->render($response, 'brands.html', [
            'brands' => $brandResult['itemList'],
            'pagination' => $brandResult['pagination'],
            'input' => $brandResult['userInput'],
        ]);
    }
}
