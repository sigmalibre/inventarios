<?php

namespace Sigmalibre\Empresas\DataSource;

/**
 * Obtiene una lista con todas las empresas sin filtrar.
 */
class SearchAllEmpresas extends FilterEmpresas
{
    protected $setLimit = false;
}