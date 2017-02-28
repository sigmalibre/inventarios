<?php

namespace Sigmalibre\UnitsOfMeasurement;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\Products\Products;
use Slim\Http\Request;
use Slim\Http\Response;

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
        $unitList = new UnitsOfMeasurement($this->container);

        // Si la medida especificada en la URL no existe, devolver un 404.
        if ($unit->is_set() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        return $this->container->view->render($response, 'unitsofmeasurement/modifyunit.twig', [
            'idMedida' => $arguments['id'],
            'unitSaved' => $isSaved,
            'failedInputs' => $failedInputs,
            'unitList' => $unitList->readAllUnitsOfMeasurement(),
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

    public function delete(Request $request, $response, $arguments)
    {
        $medida = new Unit($arguments['id'], $this->container);
        if ($medida->is_set() === false) {
            return (new Response())->withJson([
                'status' => 'error',
                'reason' => 'Not Found',
            ], 200);
        }

        /** @var MySQLTransactions $transaction */
        $transaction = $this->container->mysql;
        $transaction->beginTransaction();

        $parameters = $request->getParsedBody();
        $productos = new Products($this->container);

        if (empty($parameters['medidaSeleccionadaID']) === false) {
            $medidaReemplazo = new Unit($parameters['medidaSeleccionadaID'], $this->container);

            if ($medidaReemplazo->is_set() === false) {
                $transaction->rollBack();
                return (new Response())->withJson([
                    'status' => 'error',
                    'reason' => 'Not Found',
                ], 200);
            }

            if ($productos->replaceMedida($medida, $medidaReemplazo) === false) {
                $transaction->rollBack();
                return (new Response())->withJson([
                    'status' => 'error',
                    'reason' => 'Internal Error',
                ], 200);
            }
        }

        if (empty($parameters['eliminarProductos']) === false) {
            if ($productos->deleteFromMedida($medida) === false) {
                $transaction->rollBack();
                return (new Response())->withJson([
                    'status' => 'error',
                    'reason' => 'Internal Error',
                ], 200);
            }
        }

        if (empty($parameters['eliminarSoloMedida']) === false) {
            // EN LUGAR DE DEJAR LA MEDIDA EN BLANCO, PASAR TODOS LOS PRODUCTOS A UNA MARCA LLAMADA
            // "MEDIDA ELIMINADA"

            // Si "MEDIDA ELIMINADA" ya existe, utilizar esa.
            $medidas = new UnitsOfMeasurement($this->container);
            $medidaID = $medidas->idFromName('MEDIDA ELIMINADA');

            // Si la medida no existe, crear una nueva.
            if ($medidaID === false) {
                $medidaID = $medidas->save(['unidadMedida' => 'MEDIDA ELIMINADA']);
            }

            // Si no se pudo obtener la medida de cualquier forma.
            if ($medidaID === false) {
                $transaction->rollBack();
                return (new Response())->withJson([
                    'status' => 'error',
                    'reason' => 'Internal Error',
                ], 200);
            }

            $medidaReemplazo = new Unit($medidaID, $this->container);

            if ($productos->replaceMedida($medida, $medidaReemplazo) === false) {
                $transaction->rollBack();
                return (new Response())->withJson([
                    'status' => 'error',
                    'reason' => 'Internal Error',
                ], 200);
            }
        }

        if ($medida->delete() === false) {
            $transaction->rollBack();
            return (new Response())->withJson([
                'status' => 'error',
                'reason' => 'Internal Error',
            ], 200);
        }

        $transaction->commit();
        return (new Response())->withJson([
            'status' => 'success',
        ], 200);
    }
}
