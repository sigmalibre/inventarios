<?php

namespace Sigmalibre\Products;

/**
 * Realiza operaciones CRUD sobre los productos.
 */
class Products
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Lee la lista de todos los productos, sin filtrar resultados, con capacidad de paginación.
     *
     * @return array Lista de los productos
     */
    public function readProductList($userInput)
    {
        $listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountAllFilteredProducts($this->container),
            new DataSource\MySQL\FilterAllProducts($this->container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );

        $productList = $listReader->read();
        $productList['userInput'] = $userInput;

        return $productList;
    }
}
