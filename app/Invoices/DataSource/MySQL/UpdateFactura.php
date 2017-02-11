<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\Invoices\Factura;

class UpdateFactura
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write(Factura $factura)
    {
        return $this->connection->execute('UPDATE Facturas SET Correlativo = :correlativo, TipoFacturaID = :tipoFacturaID, EmpleadoID = :empleadoID, TirajeFacturaID = :tirajeFacturaID, EmpresaID = :empresaID, ClientesPersonasID = :clienteID WHERE FacturaID = :id', [
            'correlativo' => $factura->correlativo,
            'tipoFacturaID' => $factura->tipoFacturaID,
            'empleadoID' => $factura->empleadoID,
            'tirajeFacturaID' => $factura->tirajeFacturaID,
            'empresaID' => $factura->empresaID,
            'clienteID' => $factura->clienteID,
            'id' => $factura->id,
        ]);
    }
}