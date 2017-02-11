<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\Invoices\Factura;

class DeleteFactura
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function write(Factura $factura)
    {
        return $this->connection->execute('DELETE FROM Facturas WHERE FacturaID = :id', [
            'id' => $factura->id,
        ]);
    }
}