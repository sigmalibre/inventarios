<?php
namespace Sigmalibre\Products;

/**
 * Modelo para operaciones CRUD sobre productos.
 */
class Products
{
    protected $dataSource;

    /**
     * Obtiene cualquier fuete de datos que implemente la interfaz DataSourceInterface.
     * @param Sigmalibre\DataSource\DataSourceInterface $dataSource Fuente de datos sobre los productos.
     */
    public function __construct(\Sigmalibre\DataSource\DataSourceInterface $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    /**
     * Obtiene los productos de los cuales se haya recibido términos de búsqueda.
     * @param  [type] $identifiers Los términos de búsqueda que el usuario ha ingresado junto con sus identificadores.
     * @return array Lista con los resultados obtenidos desde la fuente de datos.
     */
    public function getProducts($identifiers)
    {
        return $this->dataSource->read($identifiers);
    }
}
