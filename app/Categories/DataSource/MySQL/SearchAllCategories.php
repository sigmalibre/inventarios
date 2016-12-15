<?php

namespace Sigmalibre\Categories\DataSource\MySQL;

/**
 * Obtiene la lista de todas las categorías desde la BD.
 */
class SearchAllCategories extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT CategoriaProductoID, Nombre FROM CategoriaProductos';
    protected $setLimit = false;
}
