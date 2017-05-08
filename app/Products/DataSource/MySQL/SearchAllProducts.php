<?php

namespace Sigmalibre\Products\DataSource\MySQL;

class SearchAllProducts extends FilterAllProducts
{
    protected $setLimit = false;
    protected $endQuery = 'GROUP BY ProductoID';
}
