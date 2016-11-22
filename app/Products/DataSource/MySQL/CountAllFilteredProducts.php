<?php

namespace Sigmalibre\Products\DataSource\MySQL;

/**
 * Realiza un query para contar la cantidad total de los productos en la BD.
 */
class CountAllFilteredProducts extends FilterAllProducts
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM Productos LEFT JOIN CategoriaProductos USING (CategoriaProductoID) LEFT JOIN Marcas USING (MarcaID) LEFT JOIN DetalleIngresos USING (ProductoID) LEFT JOIN DetalleFactura USING (ProductoID) LEFT JOIN Medidas USING (MedidaID) WHERE 1';
    protected $setLimit = false;
}
