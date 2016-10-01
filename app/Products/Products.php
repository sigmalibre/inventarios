<?php

namespace Sigmalibre\Products;

/**
 * Realiza operaciones CRUD sobre los productos.
 */
class Products
{
    private $container;
    private $userInput;

    public function __construct($container, $userInput)
    {
        $this->container = $container;
        $this->userInput = $userInput;
    }

    /**
     * Lee la lista de todos los productos, sin filtrar resultados, con capacidad de paginación.
     *
     * @return array Lista de los productos
     */
    public function readProductList()
    {
        $productSearch = new ProductSearch(new DataSource\MySQL\CountAllFilteredProducts($this->container));

        // Realizar un conteo de todos los productos existentes.
        $rowCount = (int) $productSearch->search([
            'input' => $this->userInput,
        ])[0]['cuenta'];

        // Obtiene detalles para la paginación.
        $paginator = new \Sigmalibre\Pagination\Paginator($this->userInput);
        $pagination = $paginator->calculate($rowCount);

        $productSearch->setStrategy(new DataSource\MySQL\FilterAllProducts($this->container));

        // Retornar la búsqueda de los productos según la paginación.
        $searchResults = $productSearch->search([
            'offset' => $pagination['offset'],
            'items' => $pagination['itemsPerPage'],
            'input' => $this->userInput,
        ]);

        $pagination['totalItems'] = $rowCount;

        return [
            'productList' => $searchResults,
            'pagination' => $pagination,
            'userInput' => $this->userInput,
        ];
    }
}
