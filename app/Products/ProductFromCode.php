<?php

namespace Sigmalibre\Products;

use Sigmalibre\Products\DataSource\MySQL\GetProductFromCode;

/**
 * Crea un producto a partir de su código de producto.
 */
class ProductFromCode extends Product
{
    protected function init($id)
    {
        $data_source = new GetProductFromCode($this->container);
        $this->attributes = $data_source->read([
            'input' => [
                'codigoProducto' => $id,
            ],
        ]);
    }

}