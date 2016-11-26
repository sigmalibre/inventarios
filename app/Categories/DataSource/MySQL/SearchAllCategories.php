<?php

namespace Sigmalibre\Categories\DataSource\MySQL;

class SearchAllCategories extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT CategoriaProductoID, Nombre FROM CategoriaProductos';
    protected $setLimit = false;
}
