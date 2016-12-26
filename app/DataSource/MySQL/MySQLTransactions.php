<?php

namespace Sigmalibre\DataSource\MySQL;

/**
 * Crea conexiones hacia la base de datos MySQL.
 *
 * Con capacidad para transacciones.
 */
class MySQLTransactions extends MySQL
{
    /**
     * Inicia una transacción.
     *
     * Por defecto, MySQL no soporta transacciones anidadas, debido a esto,
     * tenemos que tomar en cuenta a la hora de realizar cualquier operación
     * con transacciones si no nos encontramos ya adentro de una.
     *
     * @return bool
     */
    public function beginTransaction()
    {
        if ($this->connection->inTransaction() === false) {
            return $this->connection->beginTransaction();
        }

        return true;
    }

    /**
     * Revisa si existe una transacción activa al momento de llamar este método.
     *
     * @return bool
     */
    public function inTransaction()
    {
        return $this->connection->inTransaction();
    }

    /**
     * Hace commit a una transacción.
     *
     * @return bool
     */
    public function commit()
    {
        if ($this->connection->inTransaction() === false) {
            return false;
        }

        return $this->connection->commit();
    }

    /**
     * Cancela una transacción y revierte sus cambios.
     *
     * @return bool
     */
    public function rollBack()
    {
        if ($this->connection->inTransaction() === false) {
            return false;
        }

        return $this->connection->rollBack();
    }
}
