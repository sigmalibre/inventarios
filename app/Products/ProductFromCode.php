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

        $this->Cantidad = $this->attributes[0]['Cantidad'] ?? null;
        $this->CostoActual = $this->attributes[0]['CostoActual'] ?? null;
        $this->CategoriaProductoID = $this->attributes[0]['CategoriaProductoID'] ?? null;
        $this->CodigoProducto = $this->attributes[0]['CodigoProducto'] ?? null;
        $this->Descripcion = $this->attributes[0]['Descripcion'] ?? null;
        $this->StockMin = $this->attributes[0]['StockMin'] ?? null;
        $this->Utilidad = $this->attributes[0]['Utilidad'] ?? null;
        $this->NombreMarca = $this->attributes[0]['NombreMarca'] ?? null;
        $this->UnidadMedida = $this->attributes[0]['UnidadMedida'] ?? null;
        $this->CodigoBienDet = $this->attributes[0]['CodigoBienDet'] ?? null;
        $this->CodigoLibroDet = $this->attributes[0]['CodigoLibroDet'] ?? null;
        $this->ExcentoIVA = $this->attributes[0]['ExcentoIVA'] ?? null;
        $this->ProductoID = $this->attributes[0]['ProductoID'] ?? null;
        $this->Codigo = $this->attributes[0]['Codigo'] ?? null;
    }
}