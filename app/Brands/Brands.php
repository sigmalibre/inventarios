<?php

namespace Sigmalibre\Brands;

/**
 * Modelo para operaciones CRUD sobre las marcas.
 */
class Brands
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function readBrandList($userInput)
    {
        $listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\CountAllBrands($this->container),
            new DataSource\MySQL\FilterAllBrands($this->container),
            new \Sigmalibre\Pagination\Paginator($userInput),
            $userInput
        );

        $brandList = $listReader->read();
        $brandList['userInput'] = $userInput;

        return $brandList;
    }

    public function readAllBrands()
    {
        $brandList = new DataSource\MySQL\SearchAllBrands($this->container);

        return $brandList->read([]);
    }

    public function save($userInput)
    {
        // La marca del producto debe ser un string de 100 caracteres o menos
        if ($this->container->validator::stringType()->length(1, 100)->validate($userInput['nombreMarca']) === false) {
            return false;
        }

        $brandsWriter = new DataSource\MySQL\SaveNewBrand($this->container);

        return $brandsWriter->write($userInput);
    }
}
