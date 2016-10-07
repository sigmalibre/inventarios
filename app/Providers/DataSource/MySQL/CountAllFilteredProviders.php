<?php

namespace Sigmalibre\Providers\DataSource\MySQL;

/**
 * Realiza un conteo en la BD de todos los proveedores que cumplan con los terminos de búsqueda del usuario.
 */
class CountAllFilteredProviders extends FilterAllProviders
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM tbproveedor WHERE 1';
    protected $setLimit = false;
}
