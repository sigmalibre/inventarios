<?php

namespace Sigmalibre\Ingresos\DataSource\MySQL;

/**
 * Inserta detalles sobre el ingreso de un producto en la BD.
 */
class SaveNewIngreso
{
    /** @var \Sigmalibre\DataSource\MySQL\MySQL $connection */
    private $connection;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Guarda un nuevo detalle de compra de producto en la BD.
     *
     * Advertencia: Se espera que todos los datos vengan ya validados en este punto.
     *
     * @param array $data
     *
     * @return bool True si se creó; False de lo contrario
     */
    public function write($data)
    {
        $isSaved = $this->connection->execute('INSERT INTO DetalleIngresos (Cantidad, PrecioUnitario, CostoActual, ProductoID, EmpresaID) VALUES (:cantidadIngreso, :valorPrecioUnitario, :valorCostoActualTotal, :productoID, :empresaID)', $data);

        if ($isSaved === false) {
            return false;
        }

        return $this->connection->lastId();
    }
}
