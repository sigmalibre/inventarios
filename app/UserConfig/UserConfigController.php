<?php

namespace Sigmalibre\UserConfig;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sigmalibre\Empresas\Empresa;
use Sigmalibre\Empresas\Empresas;
use Sigmalibre\IVA\IVA;
use Sigmalibre\TirajeFactura\ColeccionTirajes;
use Sigmalibre\TirajeFactura\TirajeFactura;
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
        $configReader = new ConfigReader();

        $iva = new IVA();

        $empresas = new Empresas($this->container);
        $empresaActual = $configReader->read('empresa');

        $tirajes = new ColeccionTirajes($this->container);
        $tirajeFacturaActual = $configReader->read('factura');
        $tirajeCreditoActual = $configReader->read('credito');

        $params = $request->getQueryParams();

        return $this->container->view->render($response, 'userconfig/userconfig.twig', [
            'isSaved' => $params['saved'] ?? $isSaved ?? null,
            'porcentajeIVA' => $iva->getPorcentajeIVA(),
            'empresas' => $empresas->getAll(),
            'empresaActual' => $empresaActual,
            'tirajes' => $tirajes->getAll(),
            'facturaActual' => $tirajeFacturaActual,
            'creditoActual' => $tirajeCreditoActual,
        ]);
    }

    /**
     * Ajusta la empresa dueña del sistema, para mostrar su información en las facturas.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Slim\Http\Response
     */
    public function setEmpresa(Request $request, ResponseInterface $response)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $input = (int)$request->getParsedBody()['empresaID'] ?? -1;

        $empresa = new Empresa($input, $this->container);

        if ($empresa->is_set() === true) {
            $isSaved = (new ConfigWriter())->save('empresa', $input);
        }

        return $this->index($request, $response, $isSaved ?? false);
    }

    /**
     * Ajusta los tirajes por defecto para utilizar al crear facturas.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Slim\Http\Response
     */
    public function setTirajes(Request $request, ResponseInterface $response)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $input = $request->getParsedBody();

        $tirajeFacturaID = (int)$input['tirajeFacturaID'] ?? -1;
        $tirajeCreditoID = (int)$input['tirajeCreditoID'] ?? -1;

        if ($tirajeFacturaID == $tirajeCreditoID) {
            return $this->index($request, $response, false);
        }

        $tirajeFactura = new TirajeFactura($tirajeFacturaID, $this->container);
        $tirajeCredito = new TirajeFactura($tirajeCreditoID, $this->container);

        if ($tirajeFactura->is_set() === false || $tirajeCredito->is_set() === false) {
            return $this->index($request, $response, false);
        }

        $configWriter = new ConfigWriter();

        if (
            $configWriter->save('factura', $tirajeFacturaID) === false ||
            $configWriter->save('credito', $tirajeCreditoID) === false
        ) {
            return $this->index($request, $response, false);
        }

        return $this->index($request, $response, true);
    }
}
