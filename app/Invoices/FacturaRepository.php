<?php

namespace Sigmalibre\Invoices;

/**
 * Repositorio de facturas.
 */
interface FacturaRepository
{
    /**
     * Agrega una factura al repositorio.
     *
     * @param \Sigmalibre\Invoices\Factura $factura
     *
     * @return bool
     */
    public function add(Factura $factura): bool;

    /**
     * Remueve una factura del repositorio.
     *
     * @param \Sigmalibre\Invoices\Factura $factura
     *
     * @return bool
     */
    public function remove(Factura $factura): bool;

    /**
     * Obtiene todas las facturas disponibles.
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Obtiene una lista de facturas filtradas por campos de búsqueda.
     * Y con paginación.
     *
     * @param array $input
     *
     * @return array
     */
    public function getFiltered(array $input): array;

    /**
     * Devuelve una factura encontrada a partir de su ID.
     *
     * @param int $id
     *
     * @return false|\Sigmalibre\Invoices\Factura
     */
    public function findByID(int $id);
}