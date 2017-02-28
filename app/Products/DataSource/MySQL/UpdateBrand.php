<?php
/**
 * Created by PhpStorm.
 * User: javier
 * Date: 02-23-17
 * Time: 05:28 PM
 */

namespace Sigmalibre\Products\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;

class UpdateBrand
{
    /** @var MySQLTransactions $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($toReplaceID, $replacementID)
    {
        return $this->connection->execute('UPDATE Productos SET MarcaID = :replacementID WHERE MarcaID = :toReplaceID', [
            'replacementID' => $replacementID,
            'toReplaceID' => $toReplaceID,
        ]);
    }
}
