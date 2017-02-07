<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\Invoices\DetalleFactura\DetalleFactura;

class UpdateDetalleFactura
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function write(DetalleFactura $detalleFactura)
    {
        return $this->connection->execute('UPDATE DetalleFactura SET Cantidad = :cantidad, PrecioUnitario = :precioUnitario, ProductoID = :productoID, FacturaID = :facturaID WHERE DetalleFacutaID = :id', [
            'cantidad' =>  $detalleFactura->cantidad,
            'precioUnitario' => $detalleFactura->precioUnitario,
            'productoID' => $detalleFactura->producto->ProductoID,
            'facturaID' => $detalleFactura->facturaID,
            'id' => $detalleFactura->id,
        ]);
    }
}