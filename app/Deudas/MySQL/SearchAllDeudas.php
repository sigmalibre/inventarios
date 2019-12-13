<?php

namespace Sigmalibre\Deudas\MySQL;

class SearchAllDeudas extends \Sigmalibre\DataSource\MySQL\MySQLReader
{
    protected $baseQuery = 'SELECT DeudaID, NumeroFactura, FechaFactura, VencimientoFactura, Monto, PorcentajeInteres, Abonos, EmpresaID, NombreComercial, DATEDIFF(NOW(), VencimientoFactura) as DiasMora FROM Deudas LEFT JOIN Empresas USING(EmpresaID)';
    protected $setLimit = false;
}
