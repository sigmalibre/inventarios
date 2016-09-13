<?php
namespace Sigmalibre\DataSource;

/**
 * Interfaz para el manejo de datos, utilizar para lectura y escritura de datos.
 * Con el propósito de poder utilizar una fuente de datos (por ejemplo una DB) como plugins, en lugar de tener dependencia de ellas.
 */
interface DataSourceInterface extends ReadDataSourceInterface, WriteDataSourceInterface
{
}
