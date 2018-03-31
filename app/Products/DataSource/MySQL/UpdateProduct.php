<?php

namespace Sigmalibre\Products\DataSource\MySQL;

/**
 * Realiza un update de un producto específico según su ID.
 */
class UpdateProduct
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Ejecuta el query de UPDATE según los nuevos datos que nos haya pasado el usuario.
     *
     * Advertencia: todos los inputs para la actualización ya deberían llegar validados en este punto.
     *
     * @param array $dataList Lista con los datos a actualizar
     *
     * @return bool True si se pudo actualizar; False de lo contrario
     */
    public function write($dataList)
    {
        return $this->connection->execute('UPDATE Productos SET Codigo = :codigoProducto, Descripcion = :descripcionProducto, Detalles = :detallesProducto, Barra = :codigoBarra, ExcentoIVA = :excentoIvaProducto, StockMin = :stockMinProducto, Utilidad = :utilidadProducto, Activo = :productoActivo, CodigoLibroDet = :referenciaLibroDetProducto, CodigoBienDet = :categoriaDetProducto, MarcaID = :marcaProducto, MedidaID = :medidaProducto, CategoriaProductoID = :categoriaProducto WHERE Productos.ProductoID = :id', $dataList);
    }
}
