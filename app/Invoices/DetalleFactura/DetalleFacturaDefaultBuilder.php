<?php

namespace Sigmalibre\Invoices\DetalleFactura;

use Sigmalibre\Products\Product;

/**
 * Construye detalles de factura con datos por defecto.
 *
 * @package Sigmalibre\Invoices\DetalleFactura
 */
class DetalleFacturaDefaultBuilder implements DetalleFacturaBuilder
{
    private $container;

    private $id;
    private $cantidad;
    private $precioUnitario;
    private $producto;
    private $facturaID;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function buildID()
    {
        $this->id = 0;
    }

    public function buildCantidad()
    {
        $this->cantidad = 0;
    }

    public function buildPrecioUnitario()
    {
        $this->precioUnitario = 0;
    }

    public function buildProducto()
    {
        $this->producto = new Product(-1, $this->container);
    }

    public function buildFacturaID()
    {
        $this->facturaID = 0;
    }

    public function getDetalleFactura()
    {
        return new DetalleFactura($this->id, $this->cantidad, $this->precioUnitario, $this->producto, $this->facturaID);
    }
}