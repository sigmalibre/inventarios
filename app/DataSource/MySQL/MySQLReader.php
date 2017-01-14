<?php

namespace Sigmalibre\DataSource\MySQL;

/**
 * Clase base para las lecturas de una base de datos MySQL.
 */
abstract class MySQLReader implements \Sigmalibre\DataSource\ReadInterface
{
    protected $connection;
    protected $baseQuery = '';
    protected $endQuery = '';
    protected $setLimit = false;
    protected $filters = [];
    protected $params = [];

    protected $filterFields = [
        /* Ejemplos para establecer filtro
        [
            'filterName' => 'codigoProducto',
            'tableName'  => 'tbmaster',
            'columnName' => 'codigo_mas',
            'searchType' => 'LIKE',
        ],
        [
            'filterName' => 'nombreProducto',
            'tableName'  => 'tbmaster',
            'columnName' => 'nombre_mas',
            'searchType' => 'MATCH',
        ],
        [
            'filterName' => 'categoriaProducto',
            'tableName'  => 'tbcategoriaproductos',
            'columnName' => 'codigo_cat',
            'searchType' => '=',
        ],
        */
    ];

    public function __construct($container)
    {
        $this->connection = $container->mysql;
    }

    /**
     * Lee la lista de los campos filtrados, y si el usuario ha ingresado un filtro, se agrega el filtro al query.
     *
     * @param array $input Lista con el input del usuario
     */
    protected function setFilters($input)
    {
        foreach ($this->filterFields as $filter) {
            if (empty($input[$filter['filterName']]) === false) {

                // Si el filtro es de tipo LIKE. Ej: SELECT * FROM tabla WHERE columna LIKE 'termino de búsqueda%'
                if ($filter['searchType'] === 'LIKE') {
                    $this->filters[] = "{$filter['tableName']}.{$filter['columnName']} LIKE :{$filter['filterName']}";
                    $this->params[$filter['filterName']] = $input[$filter['filterName']].'%';
                }

                // Si el filtro es de tipo FULL TEXT. Ej: SELECT * FROM tabla WHERE MATCH(columna) AGAINST('termino de búsqueda')
                if ($filter['searchType'] === 'MATCH') {
                    $this->filters[] = "MATCH({$filter['tableName']}.{$filter['columnName']}) AGAINST(:{$filter['filterName']})";
                    $this->params[$filter['filterName']] = $input[$filter['filterName']];
                }

                // Si el filtro es de tipo igualdad. Ej: SELECT * FROM tabla WHERE columna = 'termino de búsqueda'
                if ($filter['searchType'] === '=') {
                    $this->filters[] = "{$filter['tableName']}.{$filter['columnName']} = :{$filter['filterName']}";
                    $this->params[$filter['filterName']] = $input[$filter['filterName']];
                }
            }
        }
    }

    /**
     * Realiza una lectura de los registros en una tabla, con filtros de búsqueda.
     *
     * @param array $options Opciones contiene el input del usuario y datos de paginación
     *
     * @return array Los resultados de la lectura a la BD
     */
    public function read($options)
    {
        // Si no se pasa el input del usuario en $options, utilizar un array vacío por defecto.
        $input = isset($options['input']) ? $options['input'] : [];

        $statement = $this->baseQuery;

        // Aplicar los filtros según los términos de búsqueda que el usuario nos pase como input.
        $this->setFilters($input);

        // Para cada filtro, concatenarlo en el query utilizando un AND como separador.
        if (empty($this->filters) === false) {
            $statement .= ' AND ';
            $statement .= implode(' AND ', $this->filters);
        }

        // Concatenar algo más al query al final de la instrucción WHERE.
        if (empty($this->endQuery) === false) {
            $statement .= ' '.$this->endQuery;
        }

        // Concatenar la instrucción LIMIT al final del query.
        if ($this->setLimit === true) {
            $statement .= ' LIMIT :offset, :items';

            $this->params[':offset'] = $options['offset'];
            $this->params[':items'] = $options['items'];
        }

        return $this->connection->query($statement, $this->params);
    }
}
