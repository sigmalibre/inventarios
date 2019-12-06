<?php

namespace Sigmalibre\Cotizaciones;

class Cotizaciones
{
	private $container;

	public function __construct($container)
	{
		$this->container = $container;
	}

	public function readAllCotizaciones()
	{
		$list = new DataSource\MySQL\SearchAllCotizaciones($this->container);
		$cotizaciones = $list->read([]);
		return array_map(function ($c) {
			$c['Datos'] = json_decode($c['Datos'], true);
			$c['Total'] = array_reduce($c['Datos'], function ($carry, $item) {
				return $carry + $item['excentas'] + $item['afectas'];
			}, 0);
			return $c;
		}, $cotizaciones);
	}

	public function save($data)
	{
		$insert = new DataSource\MySQL\InsertCotizacion($this->container);
		$deleter = new DataSource\MySQL\DeleteOldest($this->container);
		$insert->write($data);
		$deleter->write([]);
	}

	public function delete($id) {
		$deleter = new DataSource\MySQL\DeleteCotizacion($this->container);
		return $deleter->write($id);
	}
}
