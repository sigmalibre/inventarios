<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

use Sigmalibre\Invoices\DetalleFactura;
use Sigmalibre\Invoices\DetalleFacturaRepository;
use Sigmalibre\Invoices\Factura;
use Sigmalibre\Products\Product;

/**
 * Repositorio para detalles de factura implementado para MYSQL
 */
class MySQLDetalleFacutraRepository implements DetalleFacturaRepository
{
    /** @var \Sigmalibre\DataSource\MySQL\MySQLTransactions $connection */
    protected $connection;
    protected $container;

    public function __construct($container)
    {
        $this->connection = $container->mysql;
        $this->container = $container;
    }

    /**
     * Añade un detalle de factura al repositorio.
     *
     * @param \Sigmalibre\Invoices\DetalleFactura $detalleFactura
     *
     * @return bool
     */
    public function add(DetalleFactura $detalleFactura): bool
    {
        $isAlreadyThere = $this->findByID($detalleFactura->id);
        if ($isAlreadyThere !== false) {
            return (new UpdateDetalleFactura($this->connection))->write($detalleFactura);
        }

        return (new SaveNewDetalleFactura($this->connection))->write($detalleFactura);
    }

    /**
     * Remueve una instancia de DetalleFactura del repositorio.
     *
     * @param \Sigmalibre\Invoices\DetalleFactura $detalleFactura
     *
     * @return bool
     */
    public function remove(DetalleFactura $detalleFactura): bool
    {
        return (new DeleteDetalleFactura($this->connection))->write($detalleFactura);
    }

    /**
     * Devuelve una lista con todos los detalles de factura.
     *
     * @return array
     */
    public function getAll(): array
    {
        $results = (new FilterDetalleFactura($this->connection))->read([]);

        $collection = $this->buildCollection($results);

        return $collection;
    }

    /**
     * Encuentra un detalle de factura en el repositorio segun ID.
     *
     * @param int $id
     *
     * @return false|\Sigmalibre\Invoices\DetalleFactura
     */
    public function findByID(int $id)
    {
        $results = (new FilterDetalleFactura($this->connection))->read([
            'input' => [
                'id' => ($id > 0) ? $id : -1,
            ],
        ]);

        if (count($results) === 0) {
            return false;
        }

        $data = $results[0];

        $producto = new Product($data['ProductoID'], $this->container);

        return new DetalleFactura($id, $data['Cantidad'], $data['PrecioUnitario'], $producto, $data['FacturaID']);
    }

    /**
     * Encuentra detalles de factura según la ID de la factura
     * donde fueron creadas.
     *
     * @param \Sigmalibre\Invoices\Factura $factura
     *
     * @return array
     */
    public function findByFactura(Factura $factura): array
    {
        $results = (new FilterDetalleFactura($this->connection))->read([
            'input' => [
                'facturaID' => $factura->id,
            ],
        ]);

        $collection = $this->buildCollection($results);

        return $collection;
    }

    private function buildCollection($results): array
    {
        $collection = array_map(function ($detalle) {

            $producto = new Product($detalle['ProductoID'], $this->container);

            return new DetalleFactura($detalle['DetalleFacutaID'], $detalle['Cantidad'], $detalle['PrecioUnitario'], $producto, $detalle['FacturaID']);

        }, $results);

        return $collection;
    }
}