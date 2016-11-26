<?php

namespace Sigmalibre\DETCategories\DataSource\MySQL;

class SearchAllDETCategories extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT CodigoBienDet, Descripcion FROM CategoriasBienDet ORDER BY CodigoBienDet';
    protected $setLimit = false;
}
