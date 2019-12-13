<?php

namespace Sigmalibre\Deudas\MySQL;

class InsertDeuda
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($newDataList)
    {
        return $this->connection->execute('INSERT INTO Deudas (NumeroFactura, FechaFactura, VencimientoFactura, Monto, PorcentajeInteres, Abonos, EmpresaID) VALUES (:NumeroFactura, :FechaFactura, :VencimientoFactura, :Monto, :PorcentajeInteres, :Abonos, :EmpresaID)', $newDataList);
    }
}
