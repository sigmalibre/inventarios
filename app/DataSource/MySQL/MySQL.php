<?php
namespace Sigmalibre\DataSource\MySQL;

/**
 * Crea conexiones hacia la base de datos especificada en la configuración.
 */
class MySQL
{
    protected $connection;

    /**
     * Crea la conexión con MySQL utilizando PDO.
     * @param \Slim\Container $container Contenedor de dependencias. Las configuración de la base de datos está dentro del contenedor.
     */
    public function __construct($container)
    {
        $settings = $container['settings']['db'];

        $dsn = $settings['driver'] . ':dbname=' . $settings['database'] . ';host=' . $settings['host'] . ';charset=' . $settings['charset'];

        $this->connection = new \PDO($dsn, $settings['username'], $settings['password']);
        $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_SILENT);
        $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        $this->connection->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }

    /**
     * Realiza una consulta a la base de datos y retorna las filas obtenidas.
     * Este método se utiliza para operaciones de tipo SELECT.
     *
     * @param  string $preparedStatement La consulta en SQL a ejecutar.
     * @param  array $inputParameters Lista con los parametros a insertar en la consulta SQL.
     * @return array Lista con los registros obtenidos de la base de datos.
     */
    public function query($preparedStatement, $inputParameters)
    {
        $query = $this->connection->prepare($preparedStatement);
        $query->execute($inputParameters);

        return $query->fetchAll();
    }

    /**
     * Ejecuta una consulta a la base de datos sin retornar datos obtenidos.
     * Este método se utiliza para operaciones de tipo INSERT, UPDATE, DELETE.
     *
     * @param  string $preparedStatement La consulta en SQL a ejecutar.
     * @param  array $inputParameters Lista con los parametros a insertar en la consulta SQL.
     * @return boolean True si la consuta se ejecutó con exito, false de lo contrario.
     */
    public function execute($preparedStatement, $inputParameters)
    {
        $query = $this->connection->prepare($preparedStatement);
        return $query->execute($inputParameters);
    }

    /**
     * Obtiene la ID de la última inserción de datos.
     */
    public function lastId()
    {
        return $this->connection->lastInsertId();
    }
}
