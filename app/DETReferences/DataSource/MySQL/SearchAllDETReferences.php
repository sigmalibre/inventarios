<?php

namespace Sigmalibre\DETReferences\DataSource\MySQL;

class SearchAllDETReferences extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT CodigoLibroDet, Descripcion FROM ReferenciaLibroDet';
    protected $setLimit = false;
}
