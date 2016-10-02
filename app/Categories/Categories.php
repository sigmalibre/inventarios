<?php

namespace Sigmalibre\Categories;

/**
 * Modelo para operaciones CRUD sobre las categorías de producto.
 */
class Categories
{
    private $container;
    private $userInput;

    public function __construct($container, $userInput)
    {
        $this->container = $container;
        $this->userInput = $userInput;
    }

    /**
     * Realiza una lectura de las categorías de producto existentes.
     * @return array Lista con los datos obtenidos por la lectura, filtrados por términos de búsqueda y paginados.
     */
    public function readCategoryList()
    {
        $categorySearch = new CategorySearch(new DataSource\MySQL\CountAllFilteredCategories($this->container));

        $rowCount = (int) $categorySearch->search([
            'input' => $this->userInput,
        ])[0]['cuenta'];

        $paginator = new \Sigmalibre\Pagination\Paginator($this->userInput);
        $pagination = $paginator->calculate($rowCount);

        $categorySearch->setStrategy(new DataSource\MySQL\FilterAllCategories($this->container));

        $searchResults = $categorySearch->search([
            'offset' => $pagination['offset'],
            'items' => $pagination['itemsPerPage'],
            'input' => $this->userInput,
        ]);

        $pagination['totalItems'] = $rowCount;

        return [
            'categoryList' => $searchResults,
            'pagination' => $pagination,
            'userInput' => $this->userInput,
        ];
    }
}
