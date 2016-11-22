<?php

namespace Sigmalibre\Categories;

/**
 * Modelo para operaciones CRUD sobre las categorías de producto.
 */
class Categories
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Realiza una lectura de las categorías de producto existentes.
     *
     * @return array Lista con los datos obtenidos por la lectura, filtrados por términos de búsqueda y paginados
     */
    public function readCategoryList($userInput)
    {
        $listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountAllFilteredCategories($this->container),
            new DataSource\MySQL\FilterAllCategories($this->container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );

        $categoryList = $listReader->read();
        $categoryList['userInput'] = $userInput;

        return $categoryList;
    }
}
