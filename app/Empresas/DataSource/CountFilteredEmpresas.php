<?php

namespace Sigmalibre\Empresas\DataSource;

/**
 * Realiza un conteo con todas las empresas encontradas por el filtro.
 */
class CountFilteredEmpresas extends FilterEmpresas
{
    protected $baseQuery = 'SELECT COUNT(*) AS cuenta FROM Empresas WHERE 1';
    protected $setLimit = false;
}