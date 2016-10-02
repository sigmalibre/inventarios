<?php

namespace Sigmalibre\Categories;

/**
 * Realiza búsquedas sobre las categorías de productos, con objetos que implementen la interfaz ReadDataSourceInterface.
 */
class CategorySearch
{
    private $searchType;

    public function __construct(\Sigmalibre\DataSource\ReadDataSourceInterface $searchType)
    {
        $this->searchType = $searchType;
    }

    public function search($identifiers)
    {
        return $this->searchType->read($identifiers);
    }

    public function setStrategy(\Sigmalibre\DataSource\ReadDataSourceInterface $searchType)
    {
        $this->searchType = $searchType;
    }
}
