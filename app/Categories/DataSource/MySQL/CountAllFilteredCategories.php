<?php

namespace Sigmalibre\Categories\DataSource\MySQL;

/**
 * Consulta la BD para saber la cantidad de categorías de producto según los términos de búsqueda.
 */
class CountAllFilteredCategories extends FilterAllCategories
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM tbcategoriaproductos WHERE 1';
    protected $setLimit = false;
}
