<?php

namespace Sigmalibre\ItemList;

/**
 * Realiza una lectura de cualquier lista de datos, ajustado por las fuentes de datos.
 */
class ItemListReader
{
    private $counter;
    private $searcher;
    private $paginator;
    private $userInput;

    public function __construct(
        \Sigmalibre\DataSource\ReadInterface $counter,
        \Sigmalibre\DataSource\ReadInterface $searcher,
        \Sigmalibre\Pagination\Paginator $paginator,
        array $userInput
    ) {
        $this->counter = $counter;
        $this->searcher = $searcher;
        $this->paginator = $paginator;
        $this->userInput = $userInput;
    }

    /**
     * Lee listas desde la fuente de datos, ya que para la paginación correcta de estas listas
     * se necesita contar cuantos resultados se han encontrado, es necesario pasar primero un
     * query al constructor de esta clase que realize solo dicho conteo y después el apropiado
     * SELECT ya con la lista en sí.
     * @return array Lista con los resultados de la búsqueda.
     */
    public function read()
    {
        // Se cuenta primero cuántos resultados fueron encontrados según los terminos de búsqueda.
        // Esto debe retornar un número entero.
        $rowCount = (int) $this->counter->read([
            'input' => $this->userInput,
        ])[0]['cuenta'];

        // Luego se realizan los cálculos para la instrucción LIMIT con los datos de paginación.
        $pagination = $this->paginator->calculate($rowCount);
        $pagination['totalItems'] = $rowCount;

        // Se realiza la búsqueda en sí de los resultados de la búsqueda limitados por el cálculo
        // de la paginación.
        $searchResults = $this->searcher->read([
            'offset' => $pagination['offset'],
            'items' => $pagination['itemsPerPage'],
            'input' => $this->userInput,
        ]);

        return [
            'itemList' => $searchResults,
            'pagination' => $pagination,
        ];
    }
}
