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
        $productSearch = new ProductSearch(new DataSource\MySQL\CountAllProducts($this->container));

        // Validar los productos por página.
        $productsPerPage = isset($this->userInput['productsPerPage']) ? $this->userInput['productsPerPage'] : 10;
        $productsPerPage = $this->validatePagination($productsPerPage, 50, 10, 1);

        // Realizar un conteo de todos los productos existentes.
        $rowCount = (int) $productSearch->search([])[0]['cuenta'];

        // Calcular la cantidad de páginas según cuantos productos se quieran ver.
        $totalPages = (int) ceil($rowCount / $productsPerPage);

        // Validar la página que el cliente quiere ver.
        $productsPage = isset($this->userInput['productsPage']) ? $this->userInput['productsPage'] : 1;
        $productsPage = $this->validatePagination($productsPage, $totalPages, 1, 1);

        $pagination = [
            'currentPage' => $productsPage,
            'perPage' => $productsPerPage,
        ];

        $productSearch->setStrategy(new DataSource\MySQL\SearchAllProducts($this->container));

        // Retornar la búsqueda de los productos según la paginación.
        $searchResults = $productSearch->search($pagination);

        return [
            'productList' => $searchResults,
            'pagination' => [
                'currentPage' => $productsPage,
                'perPage' => $productsPerPage,
                'totalPages' => $totalPages,
            ]
        ];
    }

    /**
     * Valida el los input para la paginación de la lista de productos.
     *
     * @param string $input   Input desde el cliente
     * @param int    $max     Cantidad máxima para el input
     * @param int    $default Cantidad por defecto si el input es incorrecto
     * @param int    $min     Cantidad mínima para el input
     *
     * @return int El input validado
     */
    private function validatePagination($input, $max, $default, $min = 1)
    {
        if (is_numeric($input) === false) {
            return $default;
        }

        $input = (int) $input;

        if ($input < $min) {
            return $min;
        }

        if ($input > $max) {
            return $max;
        }

        return $input;
    }
}
