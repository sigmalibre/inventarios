<?php

namespace Sigmalibre\Products\DataSource\MySQL;

/**
 * Lee la lista de datos de productos, exportados desde el programa PowerAcc.
 *
 * Estos datos provienen desde el programa PowerAcc, son luego pasados a una
 * hora de Excel, desde ahí se importan en Microsoft Access para luego
 * exportarlos mediante una conexión ODBC hacia MySQL y finalmente poder
 * obtenerlos dentro de este programa. Esto se hace de esta forma porque la
 * empresa para la cual este software fue diseñado originalmente utilizaba el
 * programa PowerAcc y aunque este puede realizar respaldos directamente en
 * Access, a ellos les fue más fácil pasar los datos a Excel primero y ahí
 * realizar las correcciones necesarias a los datos antes de importarlos en este
 * sistema. Se llegó a esa decisión porque se estaba trabajando con varios miles
 * de productos y es más fácil realizar correcciones por lotes en una hoja Excel
 * que introducir uno por uno los miles de productos con los que ellos cuentan.
 */
class ObtenerProductosAImportar extends \Sigmalibre\DataSource\MySQL\MySQLReaderCustomConnection
{
    protected $baseQuery = 'SELECT Codigo, Categoria, Medida, Descripcion, Marca, Unidades, Costo FROM Productos';
    protected $setLimit = false;
}
