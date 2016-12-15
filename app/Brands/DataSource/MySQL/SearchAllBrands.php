<?php

namespace Sigmalibre\Brands\DataSource\MySQL;

/**
 * Obtiene todas las marcas sin filtrar y sin limites.
 */
class SearchAllBrands extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT MarcaID, Nombre FROM Marcas';
    protected $setLimit = false;
}
