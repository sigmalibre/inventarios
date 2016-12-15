<?php

namespace Sigmalibre\DETReferences\DataSource\MySQL;

/**
 * Obtiene una lista con todas las referencias del libro DET desde la BD.
 */
class SearchAllDETReferences extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT CodigoLibroDet, Descripcion FROM ReferenciaLibroDet';
    protected $setLimit = false;
}
