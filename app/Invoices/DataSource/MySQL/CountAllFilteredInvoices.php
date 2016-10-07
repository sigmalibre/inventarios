<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

class CountAllFilteredInvoices extends FilterAllInvoices
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM tbfactura LEFT JOIN tbempresa ON tbfactura.codigo_emp = tbempresa.codigo_cmp LEFT JOIN tbcliente USING (codigo_cln) LEFT JOIN tbsucursales USING (codigo_scr) LEFT JOIN tbuser ON tbfactura.facturadopor_fct = tbuser.codigo_user WHERE 1';
    protected $setLimit = false;
}
