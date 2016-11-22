<?php

namespace Sigmalibre\Brands\DataSource\MySQL;

class CountAllFilteredBrands extends FilterAllBrands
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM Marcas WHERE 1';
    protected $setLimit = false;
}
