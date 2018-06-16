<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

use Sigmalibre\DataSource\MySQL\MySQLTransactions;
use Sigmalibre\Invoices\Factura;
use Sigmalibre\Invoices\FacturaRepository;
use Sigmalibre\ItemList\ItemListReader;
use Sigmalibre\Pagination\Paginator;
use Sigmalibre\Invoices\DataSource\MySQL\GetLastWarehouseFromProduct;


class MySQLFacturaRepository implements FacturaRepository
{
    /** @var MySQLTransactions $connection */
    protected $connection;
    protected $container;
    protected $detallesRepo;

    public function __construct($container)
    {
        $this->container = $container;
        $this->detallesRepo = new MySQLDetalleFacutraRepository($container);
        $this->connection = $container->mysql;
    }

    /**
     * Agrega una factura al repositorio.
     *
     * @param \Sigmalibre\Invoices\Factura $factura
     *
     * @return bool
     */
    public function add(Factura $factura): bool
    {
        $this->connection->beginTransaction();

        $isSaved = (new SaveNewFactura($this->container))->write($factura);
        $factura->id = $isSaved;

        if ($isSaved === false) {
            $this->connection->rollBack();

            return false;
        }

        foreach ($factura->detalles as $detalle) {
            $detalle->facturaID = $factura->id;
            if ($this->detallesRepo->add($detalle) === false) {
                $this->connection->rollBack();

                return false;
            }
        }

        $this->connection->commit();

        return true;
    }

    /**
     * Remueve una factura del repositorio.
     *
     * @param \Sigmalibre\Invoices\Factura $factura
     *
     * @return bool
     */
    public function remove(Factura $factura): bool
    {
        return (new DeleteFactura($this->connection))->write($factura);
    }

    /**
     * Obtiene todas las facturas disponibles.
     *
     * @return array
     */
    public function getAll(): array
    {
        $results = (new SearchAllFacturas($this->container))->read([]);

        return $this->buildCollection($results);
    }

    /**
     * Obtiene una lista de facturas filtradas por campos de búsqueda.
     * Y con paginación.
     *
     * @param array $input
     *
     * @return array
     */
    public function getFiltered(array $input): array
    {
        $itemList = new ItemListReader(
            new CountFilteredFacturas($this->container),
            new FilterFacturas($this->container),
            new Paginator($input),
            $input
        );

        $results = $itemList->read();

        $collection = $this->buildCollection($results['itemList']);

        $results['itemList'] = $collection;

        return $results;
    }

    /**
     * Devuelve una factura encontrada a partir de su ID.
     *
     * @param int $id
     *
     * @return false|\Sigmalibre\Invoices\Factura
     */
    public function findByID(int $id)
    {
        $results = (new SearchAllFacturas($this->container))->read([
            'input' => [
                'id' => ($id > 0) ? $id : -1,
            ],
        ]);

        if (count($results) === 0) {
            return false;
        }

        return $this->buildCollection($results)[0] ?? false;
    }

    private function buildCollection(array $results): array
    {
        return array_map(function ($f) {

            $factura = new Factura($f['FacturaID'], $f['FechaFacturacion'], $f['TipoFacturaID'], $f['TirajeFacturaID'], $f['CodigoTiraje'], $f['Correlativo'], $f['ClientesPersonasID'], $f['NombreCliente'], $f['ApellidoCliente'], $f['EmpleadoID'], $f['CodigoEmpleado'], $f['EmpresaID'], $f['NombreEmpresa'], 0, []);

            $factura->detalles = $this->detallesRepo->findByFactura($factura);

            $factura->ventaTotal = array_reduce($factura->detalles, function ($prev, $detalle) {
                return $prev + $detalle->cantidad * $detalle->precioUnitario;
            }, 0);

            return $factura;
        }, $results);
    }

    public function getLastWarehouse($productId) {
        $getLast = new GetLastWarehouseFromProduct($this->container);
        $ultimo = $getLast->read([
            'input' => [
                'productoID' => $productId
            ],
        ]);

        return $ultimo;
    }
}