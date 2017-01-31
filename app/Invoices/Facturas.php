<?php

namespace Sigmalibre\Invoices;

/**
 * Modelo para operaciones sobre facturas de consumidor final.
 */
class Facturas
{
    private $repoFacturas;

    public function __construct(FacturaRepository $repoFacturas)
    {
        $this->repoFacturas = $repoFacturas;
    }

    public function getFiltered($input)
    {
        return $this->repoFacturas->getFiltered($input);
    }
}