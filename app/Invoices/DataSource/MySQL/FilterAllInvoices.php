<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

class FilterAllInvoices extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT codigo_fct, tbempresa.nombrecomercial_cmp, CONCAT (tbcliente.nombre_cln, \' \', tbcliente.apellido_cln) as cliente, tbsucursales.nombre_scr, totalletra_fct, suma_fct, vexentas_fct, subtotal_fct, tipofactura_fct, creditofiscal_fct, ventatotal_fct, fecha_factura, nombrerecibio_fct, duirecibio_fct, nitrecibio_fct, telrecibio_fct, nombreentrego_fct, tbuser.usuario_user, notaremision_fct, fechanotaremision_fct, giro_fct, condicionespago FROM tbfactura LEFT JOIN tbempresa ON tbfactura.codigo_emp = tbempresa.codigo_cmp LEFT JOIN tbcliente USING (codigo_cln) LEFT JOIN tbsucursales USING (codigo_scr) LEFT JOIN tbuser ON tbfactura.facturadopor_fct = tbuser.codigo_user WHERE 1';
    protected $setLimit = true;
    protected $filterFields = [
        [
            'filterName' => 'codigoFactura',
            'tableName' => 'tbfactura',
            'columnName' => 'codigo_fct',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nombreSucursal',
            'tableName' => 'tbsucursales',
            'columnName' => 'nombre_scr',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'facturadoPor',
            'tableName' => 'tbuser',
            'columnName' => 'usuario_user',
            'searchType' => 'LIKE',
        ],
    ];
}
