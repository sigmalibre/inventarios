<?php

namespace Sigmalibre\UserConfig;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sigmalibre\IVA\IVA;
use Slim\Container;
use Slim\Http\Response;

/**
 * Controlador para mostrar la página de ajustes del sistema.
 */
class UserConfigController
{
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Renderiza la vista de los ajustes del sistema.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     *
     * @return Response
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response)
    {
        $iva = new IVA();

        $params = $request->getQueryParams();

        return $this->container->view->render($response, 'userconfig/userconfig.twig', [
            'ivaSaved' => $params['ivaSaved'] ?? null,
            'porcentajeIVA' => $iva->getPorcentajeIVA(),
        ]);
    }
}