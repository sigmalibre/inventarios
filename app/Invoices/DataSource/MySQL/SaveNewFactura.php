<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\Invoices\Factura;

/**
 * Guarda una nueva factura en la BD.
 */
class SaveNewFactura
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Escribe una nueva factura en la BD.
     *
     * Advertencia: Los datos deberán llegar validados aquí.
     *
     * @param \Sigmalibre\Invoices\Factura $factura
     *
     * @return bool|string
     */
    public function write(Factura $factura)
    {
        $isSaved = $this->connection->execute('INSERT INTO Facturas (Correlativo, TipoFacturaID, EmpleadoID, TirajeFacturaID, EmpresaID, ClientesPersonasID) VALUES (:correlativo, :tipoFacturaID, :empleadoID, :tirajeFacuraID, :empresaID, :clientePersonaID)', [
            'correlativo' => $factura->correlativo,
            'tipoFacturaID' => $factura->tipoFacturaID,
            'empleadoID' => $factura->empleadoID,
            'tirajeFacuraID' => $factura->tirajeFacturaID,
            'empresaID' => $factura->empresaID,
            'clientePersonaID' => $factura->clienteID,
        ]);

        if ($isSaved === false) {
            return false;
        }

        return $this->connection->lastId();
    }
}