<?php

namespace Sigmalibre\Cotizaciones\DataSource\MySQL;

class DeleteOldest
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write()
    {
        return $this->connection->execute('DELETE FROM Cotizaciones WHERE CotizacionID <= (SELECT CotizacionID FROM (SELECT CotizacionID FROM Cotizaciones ORDER BY CotizacionID DESC LIMIT 100, 1) as X)', []);
    }
}
