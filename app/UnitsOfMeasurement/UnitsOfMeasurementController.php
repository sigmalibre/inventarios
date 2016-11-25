<?php

namespace Sigmalibre\UnitsOfMeasurement;

class UnitsOfMeasurementController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

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
