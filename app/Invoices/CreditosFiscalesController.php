<?php

namespace Sigmalibre\Invoices;

use Psr\Http\Message\ResponseInterface;
use Sigmalibre\Invoices\DataSource\MySQL\MySQLFacturaRepository;
use Sigmalibre\TirajeFactura\DataSource\JSON\TirajeActualReader;
use Slim\Http\Request;

/**
 * Controlador para operaciones sobre créditos fiscales
 */
class CreditosFiscalesController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Renderiza la vista con la lista de las facturas de crédito fical.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return object HTTP Response con la vista de las facturas
     */
    public function indexCreditos(Request $request, ResponseInterface $response)
    {
        $input = $request->getQueryParams();
        $input['tipoFactura'] = (new TirajeActualReader())->getIDTiraje('credito');

        $invoices = new Facturas(new MySQLFacturaRepository($this->container));
        $invoiceList = $invoices->getFiltered($input);

        return $this->container->view->render($response, 'invoices/creditofiscal.twig', [
            'invoices' => $invoiceList['itemList'],
            'pagination' => $invoiceList['pagination'],
            'input' => $input,
        ]);
    }
}