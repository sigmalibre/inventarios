<?php

namespace Sigmalibre\DETReferences;

/**
 * Modelo para las operaciones sobre las referencias del libro DET.
 */
class DETReferences
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Obtiene una lista con todas las referencias del libro DET desde la fuente de datos.
     *
     * @return array
     */
    public function readAllDETReferences()
    {
        $detCategoryList = new DataSource\MySQL\SearchAllDETReferences($this->container);

        return $detCategoryList->read([]);
    }
}
