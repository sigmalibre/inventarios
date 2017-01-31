<?php

namespace Sigmalibre\Invoices\DataSource\MySQL;

class SearchAllFacturas extends FilterFacturas
{
    protected $setLimit = false;
    protected $filterFields = [
        [
            'filterName' => 'id',
            'tableName' => 'Facturas',
            'columnName' => 'FacturaID',
            'searchType' => '=',
        ],
    ];
}