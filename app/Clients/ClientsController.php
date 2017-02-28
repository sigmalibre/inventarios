<?php

namespace Sigmalibre\Clients;

use Psr\Http\Message\ResponseInterface;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Controlador para las acciones sobre los clientes.
 */
class ClientsController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Responde con la vista de la lista de clientes personas.
     *
     * @param object $request  HTTP Request
     * @param object $response HTTP Response
     *
     * @return object HTTP Response con la vista de la lista de clientes personas
     */
    public function indexPeople($request, $response)
    {
        $clients = new Clients($this->container);
        $clientList = $clients->readPeopleList($request->getQueryParams());

        return $this->container->view->render($response, 'clients/clientepersona.twig', [
            'clients' => $clientList['itemList'],
            'pagination' => $clientList['pagination'],
            'input' => $clientList['userInput'],
        ]);
    }

    /**
     * Renderiza la vista del formulario para crear un nuevo contacto de cliente.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                                     $arguments
     * @param null|array                          $isSaved
     * @param null|array                          $failedInputs
     *
     * @return ResponseInterface
     */
    public function indexNew(Request $request, ResponseInterface $response, $arguments, $isSaved = null, $failedInputs = null)
    {
        return $this->container->view->render($response, 'clients/newcliente.twig', [
            'isSaved' => $isSaved,
            'failedInputs' => $failedInputs,
            'input' => $request->getParsedBody(),
        ]);
    }

    /**
     * Crea un nuevo contacto de cliente a partir del input del usuario.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function createNew(Request $request, ResponseInterface $response)
    {
        $clients = new Clients($this->container);

        $isCategorySaved = $clients->save($request->getParsedBody());

        return $this->indexNew($request, $response, null, $isCategorySaved, $clients->getInvalidInputs());
    }

    /**
     * Responde con la vista de la lista de clientes contribuyentes.
     *
     * @param object $request  HTTP Request
     * @param object $response HTTP Response
     *
     * @return object HTTP Response con la vista de la lista de clientes empresas
     */
    public function indexCompanies($request, $response)
    {
        $clients = new Clients($this->container);
        $clientList = $clients->readCompanyList($request->getQueryParams());

        return $this->container->view->render($response, 'clients/clienteempresa.twig', [
            'clients' => $clientList['itemList'],
            'pagination' => $clientList['pagination'],
            'input' => $clientList['userInput'],
        ]);
    }

    /**
     * Renderiza la vista de modificación de los datos de un cliente.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                                     $arguments
     * @param null                                $isSaved
     * @param null                                $failedInputs
     *
     * @return Response
     */
    public function indexCliente(Request $request, ResponseInterface $response, $arguments, $isSaved = null, $failedInputs = null)
    {
        $cliente = new Cliente($arguments['id'], $this->container);

        if ($cliente->is_set() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        return $this->container->view->render($response, 'clients/modificarcliente.twig', [
            'clienteID' => $arguments['id'],
            'isSaved' => $isSaved,
            'failedInputs' => $failedInputs,
            'input' => [
                'nombres' => $cliente->getNombres(),
                'apellidos' => $cliente->getApellidos(),
                'dui' => $cliente->getDui(),
                'nit' => $cliente->getNit(),
                'direccion' => $cliente->getDireccion(),
                'telefono' => $cliente->getTelefono(),
            ],
        ]);
    }

    /**
     * Actualiza los datos de un cliente.
     *
     * @param \Slim\Http\Request                  $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param                                     $arguments
     *
     * @return \Slim\Http\Response
     */
    public function update(Request $request, ResponseInterface $response, $arguments)
    {
        $cliente = new Cliente($arguments['id'], $this->container);

        if ($cliente->is_set() === false) {
            return $this->container['notFoundHandler']($request, $response);
        }

        $isSaved = $cliente->update($request->getParsedBody());

        return $this->indexCliente($request, $response, $arguments, $isSaved, $cliente->getInvalidInputs());
    }

    public function delete(Request $request, ResponseInterface $response, $arguments)
    {
        $cliente = new Cliente($arguments['id'], $this->container);
        if ($cliente->is_set() === false) {
            return (new Response())->withJson([
                'status' => 'error',
                'reason' => 'Not Found',
            ]);
        }

        if ($cliente->delete() === false) {
            return (new Response())->withJson([
                'status' => 'error',
                'reason' => 'Internal Error',
            ]);
        }

        return (new Response())->withJson([
            'status' => 'success',
        ]);
    }
}
