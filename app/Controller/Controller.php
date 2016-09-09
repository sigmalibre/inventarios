<?php
namespace Sigmalibre\Controller;

/**
 * Clase base para todos los controladores.
 * Al extender esta clase se puede obtener el contenedor como atributo.
 */
class Controller
{
    protected $container;

    /**
     * Todas las clases que extiendan esta, se deberá pasar el contenedor como atributo.
     *
     * @param \Slim\Container $container El contenedor de dependencias.
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Se utiliza __get para obtener un objeto en el contenedor.
     *
     * Ahora en lugar de escribir $this->container->obj
     * Se puede escribir simplemente $this->obj
     *
     * @param  string $property El objeto que se quiera encontrar en el contenedor.
     * @return mixed El objeto o valor, si este existe en el contenedor.
     */
    public function __get($property)
    {
        if ($this->container->{$property}) {
            var_dump($property);
            return $this->container->{$property};
        }
    }
}
