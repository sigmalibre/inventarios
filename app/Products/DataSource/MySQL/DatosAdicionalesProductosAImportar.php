<?php

namespace Sigmalibre\Products\DataSource\MySQL;

/**
 * Lee la lista de datos de productos, exportados desde el programa PowerAcc.
 *
 * Estos datos provienen del backup generado por el programa PowerAcc en una BD
 * de Microsoft Access, que luego son exportados mediante una conexión ODBC
 * hacia MySQL. Se necesita obtener dichos datos, ya que al importar los
 * productos con ObtenerProductosAImportar, hay ciertos datos que hacen falta
 * para poder completar la creación de cada producto. En específico, los datos
 * que se complementan aquí son los que refieren al DET y también la utilidad
 * del producto.
 *
 * @see \Sigmalibre\Products\DataSource\MySQL\ObtenerProductosAImportar Más información
 */
class DatosAdicionalesProductosAImportar extends \Sigmalibre\DataSource\MySQL\MySQLReaderCustomConnection
{
    protected $baseQuery = 'SELECT codigo_mas, codigo_catbiendet, codigo_reflibrodet, precio1_cst FROM tbmaster INNER JOIN tbcostos USING (codigo_mas) WHERE 1';
    protected $setLimit = false;
    protected $filterFields = [
        [
            'filterName' => 'codigoMaster',
            'tableName' => 'tbmaster',
            'columnName' => 'codigo_mas',
            'searchType' => '=',
        ],
    ];
}
