<?php

namespace Sigmalibre\UserConfig;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sigmalibre\Empresas\Empresa;
use Sigmalibre\Empresas\Empresas;
use Sigmalibre\IVA\IVA;
use Slim\Container;
use Slim\Http\Request;

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
     * @param null|bool                                $isSaved
     *
     * @return \Slim\Http\Response
     */
    public function index(ServerRequestInterface $request, ResponseInterface $response, $isSaved = null)
    {
        $iva = new IVA();
        $empresas = new Empresas($this->container);
        $empresaActual = (new ConfigReader())->read('empresa');

        $params = $request->getQueryParams();

        return $this->container->view->render($response, 'userconfig/userconfig.twig', [
            'isSaved' =>  $params['saved'] ?? $isSaved ?? null,
            'porcentajeIVA' => $iva->getPorcentajeIVA(),
            'empresas' => $empresas->getAll(),
            'empresaActual' => $empresaActual,
        ]);
    }

    public function setEmpresa(Request $request, ResponseInterface $response)
    {
        $input = (int)$request->getParsedBody()['empresaID'] ?? -1;

        $empresa = new Empresa($input, $this->container);

        if ($empresa->is_set() === true) {
            $isSaved = (new ConfigWriter())->save('empresa', $input);
        }

        return $this->index($request, $response, $isSaved ?? false);
    }
}