<?php

namespace Sigmalibre\Accounts\DataSource;


class CreateUser
{
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    public function write($newDataList)
    {
        return $this->connection->execute('INSERT INTO Usuarios (Username, Password) VALUES (:username, :password);', $newDataList);
    }
}
