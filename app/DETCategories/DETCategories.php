<?php

namespace Sigmalibre\DETCategories;

/**
 * Modelo para las operaciones sobre las categorías del bien DET.
 */
class DETCategories
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Obtiene una lista con todas las categorías DET desde la fuente de datos.
     *
     * @return array
     */
    public function readAllDETCategories()
    {
        $detCategoryList = new DataSource\MySQL\SearchAllDETCategories($this->container);

        return $detCategoryList->read([]);
    }
}
