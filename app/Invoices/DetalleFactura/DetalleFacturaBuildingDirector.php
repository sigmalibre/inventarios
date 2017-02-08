<?php

namespace Sigmalibre\Invoices\DetalleFactura;

/**
 * Construye detalles de factura a partir de una especificación
 */
class DetalleFacturaBuildingDirector
{
    private $builder;

    public function __construct(DetalleFacturaBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function make()
    {
        $this->builder->buildID();
        $this->builder->buildCantidad();
        $this->builder->buildPrecioUnitario();
        $this->builder->buildProducto();
        $this->builder->buildFacturaID();
        $this->builder->buildAlmacenID();

        return $this->builder->getDetalleFactura();
    }
}