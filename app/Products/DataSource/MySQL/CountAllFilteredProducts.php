<?php

namespace Sigmalibre\Products\DataSource\MySQL;

/**
 * Realiza un query para contar la cantidad total de los productos en la BD.
 */
class CountAllFilteredProducts extends FilterAllProducts
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM tbmaster LEFT JOIN tbproveedor USING (codigo_prov) LEFT JOIN tbcategoriaproductos USING (codigo_cat) LEFT JOIN tbsubcategoria USING (codigo_subcat) LEFT JOIN tbmedida USING (codigo_medida) LEFT JOIN tbcategoriabiendet USING (codigo_catbiendet) LEFT JOIN tbreferencialibrodet USING (codigo_reflibrodet) WHERE 1';
    protected $setLimit = false;
}
