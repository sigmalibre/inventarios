<?php

namespace Sigmalibre\Products;

/**
 * Realizar búsquedas de productos según la fuente de datos.
 */
class ProductSearch
{
    private $searchType;

    /**
     * Obtiene cualquier fuete de datos que implemente la interfaz ReadDataSourceInterface.
     *
     * @param Sigmalibre\DataSource\ReadDataSourceInterface $dataSource Fuente de datos sobre los productos
     */
    public function __construct(\Sigmalibre\DataSource\ReadDataSourceInterface $searchType)
    {
        $this->searchType = $searchType;
    }

    /**
     * Obtiene los productos de los cuales se haya recibido términos de búsqueda.
     *
     * @param [type] $identifiers Los términos de búsqueda que el usuario ha ingresado junto con sus identificadores
     *
     * @return array Lista con los resultados obtenidos desde la fuente de datos
     */
    public function search($identifiers)
    {
        return $this->searchType->read($identifiers);
    }

    public function setStrategy(\Sigmalibre\DataSource\ReadDataSourceInterface $searchType)
    {
        $this->searchType = $searchType;
    }
}
