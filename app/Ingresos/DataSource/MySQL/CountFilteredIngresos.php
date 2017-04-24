<?php

namespace Sigmalibre\Ingresos\DataSource\MySQL;

/**
 * Realiza un conteo de todos los detalles de ingreso de productos encontrados con los términos de búsqueda.
 */
class CountFilteredIngresos extends FilterIngresos
{
    protected $baseQuery = '
      SELECT
        COUNT(*) AS cuenta
      FROM DetalleIngresos
      LEFT JOIN Productos USING (ProductoID)
      LEFT JOIN CategoriaProductos USING (CategoriaProductoID)
      LEFT JOIN Marcas USING (MarcaID)
      LEFT JOIN Empresas USING (EmpresaID)
      LEFT JOIN Almacenes USING (AlmacenID)
      WHERE 1';
    protected $setLimit = false;
}
