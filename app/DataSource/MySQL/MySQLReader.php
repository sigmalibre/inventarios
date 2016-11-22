<?php

namespace Sigmalibre\DataSource\MySQL;

/**
 * Clase base para las lecturas de una base de datos MySQL.
 */
abstract class MySQLReader implements \Sigmalibre\DataSource\ReadDataSourceInterface
{
    protected $connection;
    protected $baseQuery = '';
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
        $this->connection = new MySQL($container);
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
                    $this->filters[] = "{$filter['tableName']}.{$filter['columnName']} LIKE :{$filter['columnName']}";
                    $this->params[$filter['columnName']] = $input[$filter['filterName']].'%';
                }

                // Si el filtro es de tipo FULL TEXT. Ej: SELECT * FROM tabla WHERE MATCH(columna) AGAINST('termino de búsqueda')
                if ($filter['searchType'] === 'MATCH') {
                    $this->filters[] = "MATCH({$filter['tableName']}.{$filter['columnName']}) AGAINST(:{$filter['columnName']})";
                    $this->params[$filter['columnName']] = $input[$filter['filterName']];
                }

                // Si el filtro es de tipo igualdad. Ej: SELECT * FROM tabla WHERE columna = 'termino de búsqueda'
                if ($filter['searchType'] === '=') {
                    $this->filters[] = "{$filter['tableName']}.{$filter['columnName']} = :{$filter['columnName']}";
                    $this->params[$filter['columnName']] = $input[$filter['filterName']];
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
        $input = $options['input'];

        $statement = $this->baseQuery;

        $this->setFilters($input);

        if (empty($this->filters) === false) {
            $statement .= ' AND ';
            $statement .= implode(' AND ', $this->filters);
        }

        if ($this->setLimit === true) {
            $statement .= ' LIMIT :offset, :items';

            $this->params[':offset'] = $options['offset'];
            $this->params[':items'] = $options['items'];
        }

        return $this->connection->query($statement, $this->params);
    }
}