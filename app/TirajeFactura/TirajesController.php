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
     * @param object $request  HTTP Request`
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
}
