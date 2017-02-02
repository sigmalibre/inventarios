<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\Invoices\DetalleFactura\DetalleFactura;

class DeleteDetalleFactura
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function write(DetalleFactura $detalleFactura)
    {
        return $this->connection->execute('DELETE FROM DetalleFactura WHERE DetalleFacutaID = :id', [
            'id' => $detalleFactura->id,
        ]);
    }
}