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
        if (empty($userInput['codigoProducto']) === false) {
            $codigoProducto = $userInput['codigoProducto'];

            $userInput['claveProducto'] = (string) substr($codigoProducto, 2);
            $userInput['codigoCategoria'] = (string) substr($codigoProducto, 0, 2);
        }

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

    public function save($userInput)
    {
        $productsWriter = new DataSource\MySQL\ProductWriter($this->container);

        return $productsWriter->write($userInput);
    }
}
