<?php

namespace Sigmalibre\Products\DataSource\MySQL;

/**
 * Esta clase inserta productos nuevos en la BD.
 */
class SaveNewProduct
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Guarda un producto nuevo en la BD MySQL.
     *
     * Advertencia: Todos los datos para la creación del nuevo producto ya deberían llegar validados en este punto.
     *
     * @param array $newDataList Lista con los datos para crear un producto nuevo
     *
     * @return bool True si se pudo crear el producto; False de lo contrario
     */
    public function write($newDataList)
    {
        return $this->connection->execute('INSERT INTO Productos (Codigo, Descripcion, ExcentoIVA, StockMin, CodigoLibroDet, CodigoBienDet, MarcaID, MedidaID, CategoriaProductoID) VALUES (:codigoProducto, :descripcionProducto, :excentoIvaProducto, :stockMinProducto, :referenciaLibroDetProducto, :categoriaDetProducto, :marcaProducto, :medidaProducto, :categoriaProducto)', $newDataList);
    }
}
