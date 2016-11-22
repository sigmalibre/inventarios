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

    public function indexBrands($request, $response)
    {
        $parameters = $request->getQueryParams();

        $brands = new Brands($this->container, $parameters);
        $brandResult = $brands->readBrandList();

        return $this->container->view->render($response, 'brands.html', [
            'brands' => $brandResult['itemList'],
            'pagination' => $brandResult['pagination'],
            'input' => $brandResult['userInput'],
        ]);
    }
}
