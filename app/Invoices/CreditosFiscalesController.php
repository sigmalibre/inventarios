<?php

namespace Sigmalibre\Invoices;

use Sigmalibre\UserConfig\ConfigReader;

/**
 * Controlador para operaciones sobre créditos fiscales
 */
class CreditosFiscalesController extends FacturasController
{
    protected $listViewFileName = 'invoices/creditofiscal.twig';

    public function __construct($container)
    {
        parent::__construct($container);

        $this->tirajeID = (new ConfigReader())->read('credito');
        $this->tipoFacturaID = 2;
    }
}