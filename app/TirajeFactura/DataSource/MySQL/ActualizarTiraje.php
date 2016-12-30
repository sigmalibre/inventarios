<?php

namespace Sigmalibre\TirajeFactura\DataSource\MySQL;

/**
 * Corre un query de UPDATE para actualizar la información sobre un tiraje de factura.
 */
class ActualizarTiraje
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Actualiza un tiraje existente en la BD.
     *
     * @param array $dataList Datos a actualizar
     *
     * @return bool True si se actualizó; False de lo contrario
     */
    public function write($dataList)
    {
        return $this->connection->execute('UPDATE TirajeFacturas SET CodigoTiraje = :codigoTiraje, TirajeDesde = :tirajeDesde, TirajeHasta = :tirajeHasta WHERE TirajeFacturas.TirajeFacturaID = :id', $dataList);
    }
}
