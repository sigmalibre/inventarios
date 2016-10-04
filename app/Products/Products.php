<?php

namespace Sigmalibre\Products;

/**
 * Realiza operaciones CRUD sobre los productos.
 */
class Products
{
    private $container;
    private $userInput;
    private $listReader;

    public function __construct($container, $userInput)
    {
        $this->container = $container;
        $this->userInput = $userInput;
        $this->listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountAllFilteredProducts($container),
            new DataSource\MySQL\FilterAllProducts($container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );
    }

    /**
     * Lee la lista de todos los productos, sin filtrar resultados, con capacidad de paginación.
     *
     * @return array Lista de los productos
     */
    public function readProductList()
    {
        $productList = $this->listReader->read();
        $productList['userInput'] = $this->userInput;

        return $productList;
    }
}
