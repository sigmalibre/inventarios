<?php

namespace Sigmalibre\Products\DataSource\MySQL;

/**
 * Realiza un query para contar la cantidad total de los productos en la BD.
 */
class CountAllFilteredProducts extends FilterAllProducts
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM Productos LEFT JOIN CategoriaProductos USING (CategoriaProductoID) LEFT JOIN Marcas USING (MarcaID) WHERE 1';
    protected $setLimit = false;
}
