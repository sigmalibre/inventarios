<?php

namespace Sigmalibre\DETCategories\DataSource\MySQL;

/**
 * Obtiene una lista con todas las categorías del bien DET desde la BD.
 */
class SearchAllDETCategories extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT CodigoBienDet, Descripcion FROM CategoriasBienDet ORDER BY CodigoBienDet';
    protected $setLimit = false;
}
