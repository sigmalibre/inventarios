<?php

namespace Sigmalibre\Products;

use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Controlador para hacer correr la importación de productos.
 */
class ImportarController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Corre la importación de productos.
     *
     * @param \Slim\Http\Request  $request
     * @param \Slim\Http\Response $response
     */
    public function importar(Request $request, Response $response)
    {
        $traslador = new ImportarProductos($this->container);

        $seTraslado = $traslador->importar();

        $productosConErrores = $traslador->getProductosConError();

        return $this->container->view->render($response, 'products/importarresultados.twig', [
            'importacionExitosa' => $seTraslado,
            'productosErroneos' => $productosConErrores,
        ]);
    }
}
