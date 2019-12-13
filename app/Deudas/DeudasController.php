<?php

namespace Sigmalibre\Deudas;

use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Sigmalibre\Empresas\Empresas;

class DeudasController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function listaDeudas(Request $request, ResponseInterface $response)
    {
        $empresas = new Empresas($this->container);
        $buscador = new MySQL\SearchAllDeudas($this->container);
        $lista_facturas = $buscador->read([]);
        $lista_facturas = array_map(function ($f) {
            if ($f['DiasMora'] > 0) {
                $f['InteresMora'] = ($f['Monto'] - $f['Abonos']) * ($f['PorcentajeInteres'] / 100) / 30 * $f['DiasMora'];
                
            } else {
                $f['DiasMora'] = 0;
                $f['InteresMora'] = 0;
            }
            $f['Saldo'] = $f['Monto'] - $f['Abonos'];
            return $f;
        }, $lista_facturas);
        return $this->container->view->render($response, 'deudas/listadeudas.twig', [
            'deudas' => $lista_facturas,
            'empresas' => $empresas->getAll(),
        ]);
    }

    public function editarDeuda(Request $request, ResponseInterface $response, $arguments)
    {
        $actualizador = new MySQL\ActualizarAbono($this->container);

        $body = $request->getParsedBody();

        $actualizado = $actualizador->write($arguments['id'], $body['cantidad']);

        return (new Response())->withJson([
            'saved' => $actualizado,
        ], 200);
    }

    public function eliminar(Request $request, ResponseInterface $response, $arguments)
    {
        $eliminador = new MySQL\DeleteDeuda($this->container);
        return (new Response())->withJson([
            'deleted' => $eliminador->write($arguments['id']),
        ], 200);
    }

    public function crear(Request $request, ResponseInterface $response, $arguments)
    {
        $creador = new MySQL\InsertDeuda($this->container);
        $body = $request->getParsedBody();
        return (new Response())->withJson([
            'created' => $creador->write($body),
        ], 200);
    }
}
