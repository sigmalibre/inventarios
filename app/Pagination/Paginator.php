<?php

namespace Sigmalibre\Pagination;

/**
 * Calcula la cantidad de páginas según cuantos productos se quieran en cada página
 * y según la cantidad de objetos totales que haya.
 */
class Paginator
{
    private $userInput;
    private $itemsPerPage;
    private $defaultItemsPerPage = 10;
    private $maxItemsPerPage = 100;

    /**
     * Recibe directamente el input del usuario.
     *
     * @param array $userInput El input del usuario, este debe contener los parametros itemsPerPage y currentPage
     */
    public function __construct($userInput)
    {
        $this->userInput = $userInput;
    }

    /**
     * Configura parametros para la validación de los items por página.
     *
     * @param int $default Valor por defecto para la cantidad de items por página, se usa  si la validación falla
     * @param int $max     Valor máximo de items por página, se usa si el input es mayor a este valor
     */
    public function items($default, $max)
    {
        $this->defaultItemsPerPage = $default;
        $this->maxItemsPerPage = $max;
    }

    public function calculate($itemCount)
    {
        // Verificar si el input de items por página existe y es válido, sino, por defecto es $this->defaultItemsPerPage;
        $this->itemsPerPage = isset($this->userInput['itemsPerPage']) ? $this->userInput['itemsPerPage'] : $this->defaultItemsPerPage;

        // Validar los items por página.
        $this->itemsPerPage = $this->validate($this->itemsPerPage, $this->maxItemsPerPage, $this->defaultItemsPerPage);

        // Calcular la cantidad total de páginas.
        $totalPages = (int) ceil($itemCount / $this->itemsPerPage);

        // Verificar si el input de la pagina actual existe y es válido, sino, por defecto es 1.
        $currentPage = isset($this->userInput['currentPage']) ? $this->userInput['currentPage'] : 1;

        // Validar la página actual.
        $currentPage = $this->validate($currentPage, $totalPages, 1);

        // Calcula cuantos items se omiten al inicio de la lista de resultados, creando un punto de inicio para la búsqueda.
        $offset = ($currentPage - 1) * $this->itemsPerPage;

        return [
            'offset' => $offset,
            'itemsPerPage' => $this->itemsPerPage,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
        ];
    }

    /**
     * Valida el los input para la paginación de listas de resultado.
     *
     * @param string $input   Input desde el cliente
     * @param int    $max     Cantidad máxima para el input
     * @param int    $default Cantidad por defecto si el input es incorrecto
     * @param int    $min     Cantidad mínima para el input
     *
     * @return int El input validado
     */
    private function validate($input, $max, $default)
    {
        if (is_numeric($input) === false) {
            return $default;
        }


        $input = (int) $input;

        if ($input < 1) {
            return 1;
        }

        if ($max < 1) {
            return 1;
        }

        if ($input > $max) {
            return $max;
        }

        return $input;
    }
}
