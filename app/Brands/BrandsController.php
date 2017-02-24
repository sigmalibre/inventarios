<?php

namespace Sigmalibre\Brands;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\Products\Products;
use Slim\Http\Request;
use Slim\Http\Response;

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

        return $this->container->view->render($response, 'brands/brands.twig', [
            'brands' => $brandResult['itemList'],
            'pagination' => $brandResult['pagination'],
            'input' => $brandResult['userInput'],
        ]);
    }

    /**
     * Renderiza la vista del formulario para modificar una marca.
     *
     * @param object $request      HTTP Request
     * @param object $response     HTTP Response
     * @param array  $arguments    Contiene la ID de la marca que fue modificada
     * @param bool   $isSaved      Su función es dar feedback al usuario sobre la modificación de la marca
     * @param array  $failedInputs Si la modificación falla, contiene los inputs que no pasaron la validación
     *
     * @return object La vista renderizada del formulario de modificar una marca
     */
    public function indexBrand($request, $response, $arguments, $isSaved = null, $failedInputs = null)
    {
        $brand = new Brand($arguments['id'], $this->container);
        $brands = new Brands($this->container);

        // Si la marca especificada en la URL no existe, devolver un 404.
        if ($brand->is_set() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        return $this->container->view->render($response, 'brands/modifybrand.twig', [
            'idMarca' => $arguments['id'],
            'brandSaved' => $isSaved,
            'failedInputs' => $failedInputs,
            'brandList' => $brands->readAllBrands(),
            'input' => [
                'nombreMarca' => $brand->Nombre,
            ],
        ]);
    }

    /**
     * Actualiza la información sobre una marca.
     *
     * @param object $request   HTTP Request
     * @param object $response  HTTP Response
     * @param array  $arguments Contiene la ID de la marca que será modificada
     *
     * @return object HTTP Response con la vista del formulario de modificar marca
     */
    public function update($request, $response, $arguments)
    {
        $brand = new Brand($arguments['id'], $this->container);

        // Si la marca especificada en la URL no existe, devolver un 404.
        if ($brand->is_set() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        $isBrandUpdated = $brand->update($request->getParsedBody());

        return $this->indexBrand($request, $response, $arguments, $isBrandUpdated, $brand->getInvalidInputs());
    }

    public function delete(Request $request, $response, $arguments)
    {
        $marca = new Brand($arguments['id'], $this->container);
        if ($marca->is_set() === false) {
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

        if (empty($parameters['marcaSeleccionadaID']) === false) {
            $marcaReemplazo = new Brand($parameters['marcaSeleccionadaID'], $this->container);

            if ($marcaReemplazo->is_set() === false) {
                $transaction->rollBack();
                return (new Response())->withJson([
                    'status' => 'error',
                    'reason' => 'Not Found',
                ], 200);
            }
            
            if ($productos->replaceBrand($marca, $marcaReemplazo) === false) {
                $transaction->rollBack();
                return (new Response())->withJson([
                    'status' => 'error',
                    'reason' => 'Internal Error',
                ], 200);
            }
        }
        
        if (empty($parameters['eliminarProductos']) === false) {
            if ($productos->deleteFromBrand($marca) === false) {
                $transaction->rollBack();
                return (new Response())->withJson([
                    'status' => 'error',
                    'reason' => 'Internal Error',
                ], 200);
            }
        }

        if (empty($parameters['eliminarSoloMarca']) === false) {
            // EN LUGAR DE DEJAR LA MARCA EN BLANCO, PASAR TODOS LOS PRODUCTOS A UNA MARCA LLAMADA
            // "MARCA ELIMINADA"

            // Si "MARCA ELIMINADA" ya existe, utilizar esa.
            $marcas = new Brands($this->container);
            $brandId = $marcas->idFromName('MARCA ELIMINADA');

            // Si la marca no existe, crear una nueva.
            if ($brandId === false) {
                $brandId = $marcas->save(['nombreMarca' => 'MARCA ELIMINADA']);
            }

            // Si no se pudo obtener la marca de cualquier forma.
            if ($brandId === false) {
                $transaction->rollBack();
                return (new Response())->withJson([
                    'status' => 'error',
                    'reason' => 'Internal Error',
                ], 200);
            }

            $marcaReemplazo = new Brand($brandId, $this->container);

            if ($productos->replaceBrand($marca, $marcaReemplazo) === false) {
                $transaction->rollBack();
                return (new Response())->withJson([
                    'status' => 'error',
                    'reason' => 'Internal Error',
                ], 200);
            }

            if ($marca->delete() === false) {
                $transaction->rollBack();
                return (new Response())->withJson([
                    'status' => 'error',
                    'reason' => 'Not Found',
                ], 200);
            }
        }
        
        $transaction->commit();
        return (new Response())->withJson([
            'status' => 'success',
        ], 200);
    }
}
