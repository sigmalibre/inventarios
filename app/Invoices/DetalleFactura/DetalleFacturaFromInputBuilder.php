<?php

namespace Sigmalibre\Invoices\DetalleFactura;

use Sigmalibre\Products\Product;
use Sigmalibre\Warehouses\WarehouseDetail;

/**
 * Construye detalles de factura desde el input que nos pase el usuario.
 *
 * Advertencia: El input del usuario deberá pasar primero por el validador de detalles de factura!
 *              En este punto todos los datos deberían estar validados.
 */
class DetalleFacturaFromInputBuilder implements DetalleFacturaBuilder
{
    private $container;
    private $input;

    /** @var  Product $producto */
    private $producto;
    private $id;
    private $cantidad;
    private $precioUnitario;
    private $facturaID;

    public function __construct($container, array $input)
    {
        $this->container = $container;
        $this->input = $input;
    }

    public function buildID()
    {
        $this->id = $this->input['detalleID'];
    }

    public function buildCantidad()
    {
        $this->cantidad = $this->input['cantidad'];
    }

    public function buildPrecioUnitario()
    {
        $this->precioUnitario = $this->input['precio'];
    }

    public function buildProducto()
    {
        $this->producto = new Product($this->input['productoID'], $this->container);
    }

    public function buildFacturaID()
    {
        $this->facturaID = $this->input['facturaID'];
    }

    public function getDetalleFactura()
    {
        $hayExistenciaDeProducto = new DetalleFacturaCalculardorDetalleAlamcen($this->container);

        if ($hayExistenciaDeProducto->calcular($this->input['productoID'], $this->input['almacenID'], $this->cantidad) < 0) {
            return false;
        }

        return new DetalleFactura($this->id, $this->cantidad, $this->precioUnitario, $this->producto, $this->facturaID);
    }
}