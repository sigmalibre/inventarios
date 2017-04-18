<?php

namespace Sigmalibre\IVA;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Container;
use Slim\Http\Response;

/**
 * Controlador para las operaciones sobre el IVA.
 */
class IVAController
{
    private $container;
    private $iva;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->iva = new IVA();
    }

    /**
     * Obtiene el valor del porcentaje del IVA.
     *
     * @return mixed
     */
    public function index()
    {
        return var_export($this->iva->getPorcentajeIVA(), true);
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Slim\Http\Response                      $response
     *
     * @return \Slim\Http\Response
     */
    public function update(ServerRequestInterface $request, Response $response)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $isSaved = $this->iva->setPorcentajeIVA($request->getParsedBody());

        return $response->withRedirect($this->container->router->pathFor('ajustes', [], ['saved' => (int)$isSaved]));
    }
}