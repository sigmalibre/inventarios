<?php

namespace Sigmalibre\Brands\DataSource\MySQL;

/**
 * Realiza un conteo de todas las marcas existentes en la BD.
 */
class CountAllBrands extends FilterAllBrands
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM Marcas WHERE 1';
    protected $setLimit = false;
}
