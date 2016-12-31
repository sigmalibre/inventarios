<?php

namespace Sigmalibre\IVA;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sigmalibre\UserConfig\UserConfigController;

/**
 * Controlador para las operaciones sobre el IVA.
 */
class IVAController
{
    private $container;
    private $iva;

    public function __construct($container)
    {
        $this->container = $container;
        $this->iva = new IVA();
    }

    /**
     * Obtiene el valor del porcentaje del IVA.
     *
     * @return string
     */
    public function index()
    {
        return var_export($this->iva->getPorcentajeIVA(), true);
    }

    public function update(ServerRequestInterface $request, ResponseInterface $response)
    {
        $ajustes = new UserConfigController($this->container);

        $isSaved = $this->iva->setPorcentajeIVA($request->getParsedBody());

        return $ajustes->index($request, $response, $isSaved);
    }
}