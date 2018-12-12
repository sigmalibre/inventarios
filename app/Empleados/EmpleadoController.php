<?php

namespace Sigmalibre\Empleados;

use Slim\Http\Request;
use Slim\Http\Response;
use Sigmalibre\Empleados\Empleados;
use Psr\Http\Message\ResponseInterface;

class EmpleadoController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function indexEmpleados(Request $request, ResponseInterface $response)
    {
        $empleados = new Empleados($this->container);
        $listaEmpleados = $empleados->getFiltered($request->getQueryParams());

        return $this->container->view->render($response, 'empleados/empleados.twig', [
            'empleados' => $listaEmpleados['itemList'],
            'pagination' => $listaEmpleados['pagination'],
            'input' => $listaEmpleados['userInput'],
        ]);
    }

    public function indexNew(Request $request, ResponseInterface $response, $arguments, $isSaved = null, $failedInputs = null)
    {
        return $this->container->view->render($response, 'empleados/newempleado.twig', [
            'isSaved' => $isSaved,
            'failedInputs' => $failedInputs,
            'input' => $request->getParsedBody(),
        ]);
    }

    public function createNew(Request $request, ResponseInterface $response)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $empleados = new Empleados($this->container);
        $isSaved = $empleados->save($request->getParsedBody());

        return $this->indexNew($request, $response, null, $isSaved, $empleados->getInvalidInputs());
    }

    public function indexEmpleado(Request $request, ResponseInterface $response, $arguments, $isSaved = null, $failedInputs = null)
    {
        $empleado = (new Empleados($this->container))->getEmpleado($arguments['id']);
        if ($empleado === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        return $this->container->view->render($response, 'empleados/modificarempleado.twig', [
            'empleadoID' => $arguments['id'],
            'isSaved' => $isSaved,
            'failedInputs' => $failedInputs,
            'input' => $empleado,
        ]);
    }

    public function update(Request $request, ResponseInterface $response, $arguments) {
        if ($request->getAttribute('isAdmin') !== true) {
            return $response->withRedirect('/');
        }

        $empleados = new Empleados($this->container);
        $empleado = $empleados->getEmpleado($arguments['id']);

        if ($empleado === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        $isSaved = $empleados->update($arguments['id'], $request->getParsedBody());

        return $this->indexEmpleado($request, $response, $arguments, $isSaved, $empleados->getInvalidInputs());
    }

    public function delete(Request $request, ResponseInterface $response, $arguments)
    {
        if ($request->getAttribute('isAdmin') !== true) {
            return (new Response())->withJson([
                'status' => 'error',
                'reason' => 'Not Authorized',
            ], 200);
        }

        $empleados = new Empleados($this->container);
        $empleado = $empleados->getEmpleado($arguments['id']);

        if ($empleado === false) {
            return (new Response())->withJson([
                'status' => 'error',
                'reason' => 'Internal Error',
            ], 200);
        }

        if ($empleados->delete($arguments['id']) === false) {
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
