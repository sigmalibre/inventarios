<?php

namespace Sigmalibre\UserConfig;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sigmalibre\IVA\IVA;
use Slim\Container;

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
     * @param bool                                     $ivaSaved
     *
     * @return mixed
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response, $ivaSaved = false)
    {
        $iva = new IVA();

        return $this->container->view->render($response, 'userconfig/userconfig.twig', [
            'ivaSaved' => $ivaSaved,
            'porcentajeIVA' => $iva->getPorcentajeIVA(),
        ]);
    }
}