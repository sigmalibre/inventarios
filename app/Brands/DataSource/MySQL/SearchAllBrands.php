<?php

namespace Sigmalibre\Brands\DataSource\MySQL;

class SearchAllBrands extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT MarcaID, Nombre FROM Marcas';
    protected $setLimit = false;
}
