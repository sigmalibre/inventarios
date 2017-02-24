<?php
/**
 * Created by PhpStorm.
 * User: javier
 * Date: 02-23-17
 * Time: 06:20 PM
 */

namespace Sigmalibre\Products\DataSource\MySQL;


use Sigmalibre\DataSource\MySQL\MySQLTransactions;

class DeleteFromBrand
{
    /** @var $connection MySQLTransactions */
    private $connection;

    function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($marcaID)
    {
        return $this->connection->execute('DELETE FROM Productos WHERE MarcaID = :marcaID', [
            'marcaID' => $marcaID,
        ]);
    }
}
