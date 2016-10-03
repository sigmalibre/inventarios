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
        \Sigmalibre\DataSource\ReadDataSourceInterface $counter,
        \Sigmalibre\DataSource\ReadDataSourceInterface $searcher,
        \Sigmalibre\Pagination\Paginator $paginator,
        array $userInput
    ) {
        $this->counter = $counter;
        $this->searcher = $searcher;
        $this->paginator = $paginator;
        $this->userInput = $userInput;
    }

    public function read()
    {
        $rowCount = (int) $this->counter->read([
            'input' => $this->userInput,
        ])[0]['cuenta'];

        $pagination = $this->paginator->calculate($rowCount);
        $pagination['totalItems'] = $rowCount;

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
