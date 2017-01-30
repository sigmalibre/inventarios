<?php

namespace Sigmalibre\Invoices;

use Sigmalibre\Products\Product;

class DetalleFactura
{
    public $id;
    public $cantidad;
    public $precioUnitario;
    public $producto;
    public $facturaID;

    /**
     * @param int                          $id
     * @param int                          $cantidad
     * @param float                        $precioUnitario
     * @param \Sigmalibre\Products\Product $producto
     * @param int                          $facturaID
     */
    public function __construct(int $id, int $cantidad, float $precioUnitario, Product $producto, int $facturaID)
    {
        $this->id = $id;
        $this->cantidad = $cantidad;
        $this->precioUnitario = $precioUnitario;
        $this->producto = $producto;
        $this->$facturaID = $facturaID;
    }
}