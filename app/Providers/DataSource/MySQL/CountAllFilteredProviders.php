<?php

namespace Sigmalibre\Providers\DataSource\MySQL;

/**
 * Realiza un conteo en la BD de todos los proveedores que cumplan con los terminos de búsqueda del usuario.
 */
class CountAllFilteredProviders extends FilterAllProviders
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM Empresas WHERE EmpresaID IN (SELECT DISTINCT EmpresaID FROM DetalleIngresos)';
    protected $setLimit = false;
}
