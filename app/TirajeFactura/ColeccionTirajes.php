<?php

namespace Sigmalibre\TirajeFactura;

/**
 * Modelo para manejo de colecciones de varios tirajes.
 */
class ColeccionTirajes
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Obtiene una lista con los tirajes, filtrados según términos de búsqueda
     * y limitados por paginación.
     *
     * @param array $input Los términos de búsqueda del usuario
     *
     * @return array La lista con los tirajes encontrados
     */
    public function leerFiltrados($input)
    {
        $listReader = new \Sigmalibre\ItemList\ItemListReader(
            new DataSource\MySQL\ContarTirajes($this->container),
            new DataSource\MySQL\FiltrarTirajes($this->container),
            new \Sigmalibre\Pagination\Paginator($input),
            $input
        );

        $itemList = $listReader->read();
        $itemList['userInput'] = $input;

        return $itemList;
    }
}
