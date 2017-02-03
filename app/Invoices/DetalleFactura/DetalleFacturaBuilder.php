<?php

namespace Sigmalibre\Invoices\DetalleFactura;

/**
 * Constructor de detalles de factura.
 */
interface DetalleFacturaBuilder
{
    public function buildID();

    public function buildCantidad();

    public function buildPrecioUnitario();

    public function buildProducto();

    public function buildFacturaID();

    public function getDetalleFactura();
}