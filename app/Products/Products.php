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
     * Instancia las fuentes de datos para hacer una lectura de la lista de productos.
     *
     * @return array Lista de los productos
     */
    public function readProductList()
    {
        $productCount = new DataSource\MySQL\CountAllProducts($this->container);
        $productList = new DataSource\MySQL\SearchAllProducts($this->container);

        $productSearch = new ProductSearch($productCount);

        // Si no se recibe correctamente la paginación desde el ciente, ajustar por defecto a 1.
        if (isset($this->userInput['productsPage']) === false || is_numeric($this->userInput['productsPage']) === false) {
            $productsPage = 1;
        }

        $productsPage = isset($productsPage) ? $productsPage : (int) $this->userInput['productsPage'];

        // Si no se recibe correctamente la cantidad de articulos por página desde el ciente, ajustar por defecto a 10;
        if (isset($this->userInput['productsPerPage']) === false || is_numeric($this->userInput['productsPerPage']) === false) {
            $productsPerPage = 10;
        }

        $productsPerPage = isset($productsPerPage) ? $productsPerPage : (int) $this->userInput['productsPerPage'];

        // Cantidad máxima de productos por página es 50.
        $productsPerPage = $productsPerPage > 50 ? 50 : $productsPerPage;

        $pagination = [
            'totalCountOfRows' => (int) $productSearch->search([])[0]['cuenta'],
            'currentPage' => $productsPage,
            'perPage' => $productsPerPage,
        ];

        $productSearch->setStrategy($productList);

        return $productSearch->search($pagination);
    }
}
