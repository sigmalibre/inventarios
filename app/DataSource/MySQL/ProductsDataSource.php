<?php
namespace Sigmalibre\DataSource\MySQL;

/**
 * Fuente de datos de los productos en MySQL.
 */
class ProductsDataSource implements \Sigmalibre\DataSource\DataSourceInterface
{
    protected $db;

    public function __construct($container)
    {
        $this->db = new MySQL($container);
    }

    /**
     * Revisa si un string NO está vacío y le agrega un % al final.
     * Con el propósito de evitar que strings vacíos retornen todos los resultados en una búsqueda tipo LIKE '%'.
     * También escapa cualquier wildcard que el usuario introduzca como parte del string de búsqueda.
     * @param string $identifier El identificador el cual será revisado.
     * @return string El identificador más un % si el string no estaba vacío.
     */
    protected function escWildCards($identifier)
    {
        return (empty($identifier))? '': addcslashes($identifier, '%_') . '%';
    }

    /**
     * Utiliza MySQL para realizar una búsqueda de todos los campos de la tabla productos.
     * @param  array $identifiers Términos de búsqueda que el usuario ha ingresado, junto con su respectivo identificador de columna.
     * @return array Los resultados de la búsqueda, si se encontraron coincidencias.
     */
    public function read($identifiers)
    {
        $preparedStatement = "SELECT * FROM productos WHERE";
        $inputParameters = [];

        $add_AND_before = '';

        if (empty($identifiers['codigoProducto']) === false) {
            $preparedStatement .= ' codigo_producto LIKE :codigo';
            $inputParameters[':codigo'] = $this->escWildCards($identifiers['codigoProducto']);
            $add_AND_before = ' AND';
        }

        if (empty($identifiers['marcaProducto']) === false) {
            $preparedStatement .= $add_AND_before . ' marca_producto LIKE :marca';
            $inputParameters[':marca'] = $this->escWildCards($identifiers['marcaProducto']);
            $add_AND_before = ' AND';
        }

        if (empty($identifiers['modeloProducto']) === false) {
            $preparedStatement .= $add_AND_before . ' modelo_producto LIKE :modelo';
            $inputParameters[':modelo'] = $this->escWildCards($identifiers['modeloProducto']);
            $add_AND_before = ' AND';
        }

        if (empty($identifiers['ubicacionProducto']) === false) {
            $preparedStatement .= $add_AND_before . ' ubicacion_producto LIKE :ubicacion';
            $inputParameters[':ubicacion'] = $this->escWildCards($identifiers['ubicacionProducto']);
            $add_AND_before = ' AND';
        }

        if (empty($identifiers['descripcionProducto']) === false) {
            $preparedStatement .= $add_AND_before . ' MATCH(descripcion_producto) AGAINST(:descripcion)';
            $inputParameters[':descripcion'] = $this->escWildCards($identifiers['descripcionProducto']);
        }

        if (empty($inputParameters) === true) {
            $preparedStatement = 'SELECT * FROM productos';
        }

        $preparedStatement .= ' LIMIT 15';

        return $this->db->query($preparedStatement, $inputParameters);
    }

    public function write($newDataList)
    {

    }

    public function update($identifiers, $newDataToUpdateList)
    {

    }

    public function delete($identifiers)
    {

    }
}
