<?php

namespace Sigmalibre\Categories\DataSource\MySQL;

class SearchAllCategories extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT CategoriaProductoID, Nombre, Codigo FROM CategoriaProductos';
    protected $setLimit = false;
}
