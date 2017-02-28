<?php

namespace Sigmalibre\Products\DataSource\MySQL;


class UpdateMedida
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($toReplaceID, $replacementID)
    {
        return $this->connection->execute('UPDATE Productos SET MedidaID = :replacementID WHERE MedidaID = :toReplaceID', [
            'replacementID' => $replacementID,
            'toReplaceID' => $toReplaceID,
        ]);
    }
}
