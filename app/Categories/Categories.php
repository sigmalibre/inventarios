<?php

namespace Sigmalibre\Categories;

/**
 * Modelo para operaciones CRUD sobre las categorías de producto.
 */
class Categories
{
    private $container;
    private $userInput;
    private $listReader;

    public function __construct($container, $userInput)
    {
        $this->container = $container;
        $this->userInput = $userInput;
        $this->listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountAllFilteredCategories($container),
            new DataSource\MySQL\FilterAllCategories($container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );
    }

    /**
     * Realiza una lectura de las categorías de producto existentes.
     *
     * @return array Lista con los datos obtenidos por la lectura, filtrados por términos de búsqueda y paginados
     */
    public function readCategoryList()
    {
        $categoryList = $this->listReader->read();
        $categoryList['userInput'] = $this->userInput;

        return $categoryList;
    }
}
