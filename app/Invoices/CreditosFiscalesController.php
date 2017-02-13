<?php

namespace Sigmalibre\Invoices;

use Sigmalibre\DataSource\JSON\TirajeActualReader;

/**
 * Controlador para operaciones sobre créditos fiscales
 */
class CreditosFiscalesController extends FacturasController
{
    protected $listViewFileName = 'invoices/creditofiscal.twig';

    public function __construct($container)
    {
        parent::__construct($container);

        $this->tirajeID = (new TirajeActualReader())->getIDTiraje('credito');
        $this->tipoFacturaID = 2;
    }
}