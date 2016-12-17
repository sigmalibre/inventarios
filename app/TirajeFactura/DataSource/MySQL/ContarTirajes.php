<?php

namespace Sigmalibre\TirajeFactura\DataSource\MySQL;

/**
 * Realiza una cuenta de la cantidad de tirajes existentes en la BD.
 */
class ContarTirajes extends FiltrarTirajes
{
    protected $baseQuery = 'SELECT COUNT(*) as cuenta FROM TirajeFacturas WHERE 1';
    protected $endQuery = '';
    protected $setLimit = false;
}
