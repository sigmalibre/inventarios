<?php

namespace Sigmalibre\TirajeFactura\DataSource\MySQL;

/**
 * Inserta tirajes nuevos en la BD.
 */
class GuardarNuevoTiraje
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Guarda un tiraje nuevo en la BD MySQL.
     *
     * @param array $newDataList Lista con los datos para crear un tiraje nuevo
     *
     * @return bool|string Retorna la ID del nuevo tiraje si este fue creado; False de lo contrario
     */
    public function write($newDataList)
    {
        $isSaved = $this->connection->execute('INSERT INTO TirajeFacturas (CodigoTiraje, TirajeDesde, TirajeHasta) VALUES (:codigoTiraje, :tirajeDesde, :tirajeHasta)', $newDataList);

        return $isSaved;
    }
}
