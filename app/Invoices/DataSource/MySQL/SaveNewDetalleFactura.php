<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\Invoices\DetalleFactura\DetalleFactura;

class SaveNewDetalleFactura
{
    private $connection;

    public function __construct(MySQLTransactions $connection)
    {
        $this->connection = $connection;
    }

    public function write(DetalleFactura $detalleFactura)
    {
        return $this->connection->execute('INSERT INTO DetalleFactura (Cantidad, PrecioUnitario, ProductoID, FacturaID, AlmacenID) VALUES (:cantidad, :precioUnitario, :productoID, :facturaID, :almacenID);', [
            'cantidad' => $detalleFactura->cantidad,
            'precioUnitario' => $detalleFactura->precioUnitario,
            'productoID' => $detalleFactura->producto->ProductoID,
            'facturaID' => $detalleFactura->facturaID,
            'almacenID' => $detalleFactura->almacenID,
        ]);
    }
}