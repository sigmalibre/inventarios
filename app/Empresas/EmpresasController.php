<?php

namespace Sigmalibre\Empresas;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class EmpresasController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Renderiza la vista con la lista de las empresas encontradas por los términos de búsqueda.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return Response
     */
    public function indexEmpresas(Request $request, ResponseInterface $response)
    {
        $empresas = new Empresas($this->container);
        $listaEmpresas = $empresas->getFiltered($request->getQueryParams());

        return $this->container->view->render($response, 'empresas/empresas.twig', [
            'empresas' => $listaEmpresas['itemList'],
            'pagination' => $listaEmpresas['pagination'],
            'input' => $listaEmpresas['userInput'],
        ]);
    }

    /**
     *
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                                     $arguments
     * @param null|bool                           $isSaved
     * @param null|array                          $failedInputs
     *
     * @return Response
     */
    public function indexNew(Request $request, ResponseInterface $response, $arguments, $isSaved = null, $failedInputs = null)
    {
        return $this->container->view->render($response, 'empresas/newempresa.twig', [
            'isSaved' => $isSaved,
            'failedInputs' => $failedInputs,
            'input' => $request->getParsedBody(),
        ]);
    }

    /**
     * Crea una nueva empresa a partir del input del usuario.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Slim\Http\Response
     */
    public function createNew(Request $request, ResponseInterface $response)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $empresas = new Empresas($this->container);
        $isSaved = $empresas->save($request->getParsedBody());

        return $this->indexNew($request, $response, null, $isSaved, $empresas->getInvalidInputs());
    }

    /**
     * Renderiza la vista del formulario de modificación de una empresa.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                                     $arguments
     * @param null|bool                           $isSaved
     * @param null|array                          $failedInputs
     *
     * @return Response
     */
    public function indexEmpresa(Request $request, ResponseInterface $response, $arguments, $isSaved = null, $failedInputs = null)
    {
        $empresa = new Empresa($arguments['id'], $this->container);
        if ($empresa->is_set() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        return $this->container->view->render($response, 'empresas/modificarempresa.twig', [
            'empresaID' => $arguments['id'],
            'isSaved' => $isSaved,
            'failedInputs' => $failedInputs,
            'input' => [
                'nombreComercial' => $empresa->getNombre(),
                'razonSocial' => $empresa->getRazonSocial(),
                'giro' => $empresa->getGiro(),
                'registro' => $empresa->getRegistro(),
                'nit' => $empresa->getNit(),
                'direccion' => $empresa->getDireccion(),
                'telefono' => $empresa->getTelefono(),
                'email' => $empresa->getEmail(),
            ],
        ]);
    }

    /**
     * Actualiza los datos de una empresa a partir del input del usuario.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                                     $arguments
     *
     * @return \Slim\Http\Response
     */
    public function update(Request $request, ResponseInterface $response, $arguments)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $empresa = new Empresa($arguments['id'], $this->container);

        if ($empresa->is_set() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        $isSaved = $empresa->update($request->getParsedBody());

        return $this->indexEmpresa($request, $response, $arguments, $isSaved, $empresa->getInvalidInputs());
    }

    public function delete(Request $request, ResponseInterface $response, $arguments)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $empresa = new Empresa($arguments['id'], $this->container);

        if ($empresa->is_set() === false) {
            return (new Response())->withJson([
                'status' => 'error',
                'reason' => 'Not Found',
            ], 200);
        }

        if ($empresa->delete() === false) {
            return (new Response())->withJson([
                'status' => 'error',
                'reason' => 'Internal Error',
            ], 200);
        }

        return (new Response())->withJson([
            'status' => 'success',
        ], 200);
    }
}
