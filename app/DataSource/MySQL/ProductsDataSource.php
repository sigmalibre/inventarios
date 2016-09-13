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
    protected function setWildCards($identifier)
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
        $preparedStatement = "SELECT * FROM productos WHERE codigo_producto LIKE :codigo OR marca_producto LIKE :marca OR modelo_producto LIKE :modelo OR ubicacion_producto LIKE :ubicacion OR MATCH(descripcion_producto) AGAINST(:descripcion);";

        $inputParameters = [
            ':codigo' => $this->setWildCards($identifiers['codigo']),
            ':marca' => $this->setWildCards($identifiers['marca']),
            ':modelo' => $this->setWildCards($identifiers['modelo']),
            ':ubicacion' => $this->setWildCards($identifiers['ubicacion']),
            ':descripcion' => addcslashes($identifiers['descripcion'], '*'),
        ];

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
