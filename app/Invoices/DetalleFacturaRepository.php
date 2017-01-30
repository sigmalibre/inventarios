<?php

namespace Sigmalibre\Invoices;

/**
 * Repositorio para detalles de factura
 */
interface DetalleFacturaRepository
{
    /**
     * Añade un detalle de factura al repositorio.
     *
     * @param \Sigmalibre\Invoices\DetalleFactura $detalleFactura
     *
     * @return bool
     */
    public function add(DetalleFactura $detalleFactura): bool;

    /**
     * Remueve una instancia de DetalleFactura del repositorio.
     *
     * @param \Sigmalibre\Invoices\DetalleFactura $detalleFactura
     *
     * @return bool
     */
    public function remove(DetalleFactura $detalleFactura): bool;

    /**
     * Devuelve una lista con todos los detalles de factura.
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Encuentra un detalle de factura en el repositorio segun ID.
     *
     * @param int $id
     *
     * @return false|\Sigmalibre\Invoices\DetalleFactura
     */
    public function findByID(int $id);

    /**
     * Encuentra detalles de factura según la ID de la factura
     * donde fueron creadas.
     *
     * @param \Sigmalibre\Invoices\Factura $factura
     *
     * @return array
     */
    public function findByFactura(Factura $factura): array;
}