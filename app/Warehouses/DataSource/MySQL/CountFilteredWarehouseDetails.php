<?php

namespace Sigmalibre\Warehouses\DataSource\MySQL;

/**
 * Relaliza un conteo de todos los detalles de almacen filtrados.
 */
class CountFilteredWarehouseDetails extends FilterWarehouseDetails
{
    protected $baseQuery = 'SELECT COUNT(*) AS cuenta FROM DetalleAlmacenes';
    protected $setLimit = false;
}