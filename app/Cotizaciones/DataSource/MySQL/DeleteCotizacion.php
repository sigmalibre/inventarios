<?php

namespace Sigmalibre\Cotizaciones\DataSource\MySQL;

class DeleteCotizacion
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($id)
    {
        return $this->connection->execute('DELETE FROM Cotizaciones WHERE CotizacionID = :cotizacion', [
			'cotizacion' => $id,
		]);
    }
}