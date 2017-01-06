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
     * Cuenta la cantidad de transacciones iniciadas, para evitar transacciones
     * anidadas.
     *
     * @var int
     */
    protected $transactionCounter = 0;

    /**
     * Inicia una transacción.
     *
     * Por defecto, MySQL no soporta transacciones anidadas, debido a esto,
     * tenemos que tomar en cuenta a la hora de realizar cualquier operación
     * con transacciones si no nos encontramos ya adentro de una.
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function beginTransaction()
    {
        // Probar que no estemos dentro de una transacción.
        if ($this->connection->inTransaction() === false) {

            // Si no estamos dentro de una transacción, pero ya se han iniciado
            // varias, significa que en algun momento falló la conexión o
            // ocurrió algún error y nos salimos de la transacción.
            if ($this->transactionCounter > 0) {
                throw new \RuntimeException('No se encuentra transacción existente');
            }

            // Probamos si se inició la transacción.
            if ($this->connection->beginTransaction() === true) {
                $this->transactionCounter = 1;

                return true;
            }

            // Si no se inició la transacción.
            throw new \RuntimeException('No se pudo iniciar una transacción');
        }

        // Si ya estamos dentro de una transacción.
        ++$this->transactionCounter;

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
     * @throws \RuntimeException
     */
    public function commit()
    {
        if ($this->connection->inTransaction() === false) {

            // Si no estamos dentro de una transacción, pero ya se han iniciado
            // varias, significa que en algun momento falló la conexión o
            // ocurrió algún error y nos salimos de la transacción.
            if ($this->transactionCounter > 0) {
                throw new \RuntimeException('No se encuentra transacción existente');
            }

            return false;
        }

        // Si estamos dentro de una transacción.

        // Si esa transacción no ha sido iniciada en este script.
        if ($this->transactionCounter < 1) {
            throw new \RuntimeException('Ya existe una transacción iniciada por otro servicio');
        }

        // Si hay transacciones pseudo-anidadas, al hacer commit se reduce la
        // cantidad por uno.
        if ($this->transactionCounter > 1) {
            --$this->transactionCounter;

            return true;
        }

        // Si la cuenta de transacciones es una sola.
        // Si se pudo realizar el commit.
        if ($this->connection->commit() === true) {
            $this->transactionCounter = 0;

            return true;
        }

        // Si no se pudo realizar el commit.
        throw new \RuntimeException('No se pudo cometer la transacción actual');
    }

    /**
     * Cancela una transacción y revierte sus cambios.
     *
     * @return bool
     * @throws \RuntimeException
     */
    public function rollBack()
    {
        if ($this->connection->inTransaction() === false) {

            // Si no estamos dentro de una transacción, pero ya se han iniciado
            // varias, significa que en algun momento falló la conexión o
            // ocurrió algún error y nos salimos de la transacción.
            if ($this->transactionCounter > 0) {
                throw new \RuntimeException('No se encuentra transacción existente');
            }

            return false;
        }

        // Si estamos dentro de una transacción.

        // Si esa transacción no ha sido iniciada en este script.
        if ($this->transactionCounter < 1) {
            throw new \RuntimeException('Ya existe una transacción iniciada por otro servicio');
        }

        // Si se pudo realizar el rollback.
        if ($this->connection->rollBack() === true) {
            $this->transactionCounter = 0;

            return true;
        }

        // Si no se pudo realizar el commit.
        throw new \RuntimeException('No se pudo revertir la transacción actual');
    }
}
