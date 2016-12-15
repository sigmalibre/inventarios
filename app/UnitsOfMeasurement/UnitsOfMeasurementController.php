<?php

namespace Sigmalibre\UnitsOfMeasurement;

/**
 * Controlador para las operaciones sobre las unidades de medida de productos.
 */
class UnitsOfMeasurementController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Renderiza la vista que muestra la lista de las unidades de medida.
     *
     * @param object $request  HTTP Request
     * @param object $response HTTP Response
     *
     * @return object HTTP Response con la vista renderizada
     */
    public function indexMeasurements($request, $response)
    {
        $measurements = new UnitsOfMeasurement($this->container);
        $measurementList = $measurements->readMesurementList($request->getQueryParams());

        return $this->container->view->render($response, 'unitsofmeasurement/measurements.html', [
            'measurements' => $measurementList['itemList'],
            'pagination' => $measurementList['pagination'],
            'input' => $measurementList['userInput'],
        ]);
    }
}
