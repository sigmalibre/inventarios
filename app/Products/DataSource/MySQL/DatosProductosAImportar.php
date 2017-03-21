<?php

namespace Sigmalibre\Products\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLReaderCustomConnection;

/**
 * Lee la lista de datos de productos, exportados desde el programa PowerAcc.
 */
class DatosProductosAImportar extends MySQLReaderCustomConnection
{
    protected $baseQuery = '
    SELECT
        codigo_mas as Codigo,
        nombre_cat as Categoria,
        nombre_mas as Descripcion,
        precio1_cst as Utilidad,
        codigo_reflibrodet as ReferenciaLibroDet,
        codigo_catbiendet as CodigoBienDet,
        marca_mas as Marca,
        nombre_medida as Medida,
        saldou_mas as Unidades,
        promedio_mas as Costo
    FROM tbmaster
    LEFT JOIN tbcategoriaproductos USING (codigo_cat)
    LEFT JOIN tbcostos USING (codigo_mas)
    LEFT JOIN tbmedida USING (codigo_medida)
    WHERE activo = 1';
    protected $setLimit = false;
}
