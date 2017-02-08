<?php

namespace Sigmalibre\Invoices\DetalleFactura;

use Sigmalibre\Warehouses\WarehouseDetail;

class DetalleFacturaCalculardorDetalleAlamcen
{
    private $container;

    function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Calcula la cantidad restante si se retiraran cierta cantidad de un producto determinado
     * de un almacén.
     *
     * @param $productoID
     * @param $almacenID
     * @param $cantidadADescontar
     *
     * @return int
     */
    public function calcular($productoID, $almacenID, $cantidadADescontar)
    {
        $warehouseDetails = new WarehouseDetail($this->container);

        $existencia = $warehouseDetails->readList(['productoID' => $productoID])['itemList'];

        if (count($existencia) === 0) {
            return -1;
        }

        $existencia = array_filter($existencia, function ($detalleAlmacen) use ($almacenID) {
            return $detalleAlmacen['AlmacenID'] == $almacenID;
        })[0];

        return (int)$existencia['Cantidad'] - $cantidadADescontar;
    }
}