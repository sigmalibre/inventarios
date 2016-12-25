<?php

namespace Sigmalibre\Products;

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
     */
    public function importar()
    {
        $traslador = new ImportarProductos($this->container);

        $seTraslado = $traslador->importar();

        var_dump($traslador->obtenerProductosNoCreados());
    }
}
