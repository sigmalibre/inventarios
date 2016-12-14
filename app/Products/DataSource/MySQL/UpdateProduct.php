<?php

namespace Sigmalibre\Products\DataSource\MySQL;

class UpdateProduct
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = new \Sigmalibre\DataSource\MySQL\MySQL($container);
    }

    public function write($dataList)
    {
        return $this->connection->execute('UPDATE Productos SET Codigo = :codigoProducto, Descripcion = :descripcionProducto, ExcentoIVA = :excentoIvaProducto, StockMin = :stockMinProducto, CodigoLibroDet = :referenciaLibroDetProducto, CodigoBienDet = :categoriaDetProducto, MarcaID = :marcaProducto, MedidaID = :medidaProducto, CategoriaProductoID = :categoriaProducto WHERE Productos.ProductoID = :id', $dataList);
    }
}
