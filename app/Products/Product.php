<?php

namespace Sigmalibre\Products;

class Product
{
    private $container;
    private $attributes;

    public function __construct($id, $container)
    {
        $this->container = $container;

        $getProductFromID = new DataSource\MySQL\GetProductFromID($container);

        $this->attributes = $getProductFromID->read([
            'input' => [
                'idProducto' => $id,
            ],
        ]);
    }

    public function isset()
    {
        return isset($this->attributes[0]);
    }

    public function __get($property)
    {
        if (isset($this->attributes[0][$property])) {
            return $this->attributes[0][$property];
        }
    }
}
