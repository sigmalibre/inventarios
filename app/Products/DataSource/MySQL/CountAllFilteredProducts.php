<?php

namespace Sigmalibre\Products\DataSource\MySQL;

/**
 * Realiza un query para contar la cantidad total de los productos en la BD.
 */
class CountAllFilteredProducts extends FilterAllProducts
{
    protected $baseQuery = 'SELECT COUNT(*) AS cuenta FROM VistaProductosCompletos WHERE 1';
    protected $setLimit = false;
}
