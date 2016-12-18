<?php

namespace Sigmalibre\TirajeFactura;

/**
 * Controlador para las acciones sobre los tirajes de facturación.
 */
class TirajesController
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Renderiza la vista de búsqueda de tirajes de factura.
     *
     * @param object $request  HTTP Request
     * @param object $response HTTP Response
     *
     * @return object HTTP Response con la vista renderizada
     */
    public function indexListaTirajes($request, $response)
    {
        $listaTirajes = new ColeccionTirajes($this->container);
        $resultadoBusqueda = $listaTirajes->leerFiltrados($request->getQueryParams());

        return $this->container->view->render($response, 'tirajes/listatirajes.html', [
            'tirajes' => $resultadoBusqueda['itemList'],
            'pagination' => $resultadoBusqueda['pagination'],
            'input' => $resultadoBusqueda['userInput'],
        ]);
    }

    /**
     * Renderiza la vista del formulario de creación de tirajes de factura.
     *
     * @param object $request      HTTP Request
     * @param object $response     HTTP Response
     * @param array  $arguments    Ignorar
     * @param bool   $isSaved      Da feedback al usuario sobre si se creó el tiraje anterior
     * @param array  $failedInputs Contiene todos los inputs que no pasaron la validación al crear uno nuevo
     *
     * @return object HTTP Reseponse con la vista renderizada
     */
    public function indexNew($request, $response, $arguments, $isSaved = null, $failedInputs = null)
    {
        return $this->container->view->render($response, 'tirajes/nuevotiraje.html', [
            'saved' => $isSaved,
            'failedInputs' => $failedInputs,
            'input' => $request->getParsedBody(),
        ]);
    }

    /**
     * Crea un nuevo tiraje de factura.
     *
     * @param object $request  HTTP Request
     * @param object $response HTTP Response
     *
     * @return object HTTP Request con la vista del formulario de nuevo tiraje
     */
    public function createNew($request, $response)
    {
        $creador = new CreadorTirajes($this->container);

        $isSaved = $creador->save($request->getParsedBody());

        return $this->indexNew($request, $response, null, $isSaved, $creador->getInvalidInputs());
    }
}
