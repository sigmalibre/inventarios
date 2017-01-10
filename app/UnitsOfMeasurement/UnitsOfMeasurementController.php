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

        return $this->container->view->render($response, 'unitsofmeasurement/measurements.twig', [
            'measurements' => $measurementList['itemList'],
            'pagination' => $measurementList['pagination'],
            'input' => $measurementList['userInput'],
        ]);
    }

    /**
     * Renderiza la vista del formulario para modificar una medida.
     *
     * @param object $request      HTTP Request
     * @param object $response     HTTP Response
     * @param array  $arguments    Contiene la ID de la medida que fue modificada
     * @param bool   $isSaved      Su función es dar feedback al usuario sobre la modificación de la medida
     * @param array  $failedInputs Si la modificación falla, contiene los inputs que no pasaron la validación
     *
     * @return object La vista renderizada del formulario de modificar una unidad de medida
     */
    public function indexUnit($request, $response, $arguments, $isSaved = null, $failedInputs = null)
    {
        $unit = new Unit($arguments['id'], $this->container);

        // Si la medida especificada en la URL no existe, devolver un 404.
        if ($unit->is_set() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        return $this->container->view->render($response, 'unitsofmeasurement/modifyunit.twig', [
            'idMedida' => $arguments['id'],
            'unitSaved' => $isSaved,
            'failedInputs' => $failedInputs,
            'input' => [
                'unidadMedida' => $unit->UnidadMedida,
            ],
        ]);
    }

    /**
     * Actualiza una unidadd de medida según el input que se recibe del usuario.
     *
     * @param object $request   HTTP Request
     * @param object $response  HTTP Respose
     * @param array  $arguments Contiene la ID de la unidad que será actualizada
     *
     * @return object HTTP Response con la vista del formulario modificar unidad de medida
     */
    public function update($request, $response, $arguments)
    {
        $unit = new Unit($arguments['id'], $this->container);

        // Si la medida especificada en la URL no existe, devolver un 404.
        if ($unit->is_set() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        $isUnitUpdated = $unit->update($request->getParsedBody());

        return $this->indexUnit($request, $response, $arguments, $isUnitUpdated, $unit->getInvalidInputs());
    }
}
