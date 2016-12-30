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
     * @return bool|string Retorna la ID del nuevo producto si se pudo crear; False de lo contrario
     */
    public function write($newDataList)
    {
        $isSaved = $this->connection->execute('INSERT INTO Productos (Codigo, Descripcion, ExcentoIVA, StockMin, Utilidad, CodigoLibroDet, CodigoBienDet, MarcaID, MedidaID, CategoriaProductoID) VALUES (:codigoProducto, :descripcionProducto, :excentoIvaProducto, :stockMinProducto, :utilidadProducto, :referenciaLibroDetProducto, :categoriaDetProducto, :marcaProducto, :medidaProducto, :categoriaProducto)', $newDataList);

        if ($isSaved === false) {
            return false;
        }

        return $this->connection->lastId();
    }
}
