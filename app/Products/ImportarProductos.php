<?php

namespace Sigmalibre\Products;

use Sigmalibre\Brands\Brands;
use Sigmalibre\Categories\Categories;
use Sigmalibre\DataSource\MySQL\MySQLCustomDatabase;
use Sigmalibre\Ingresos\Ingresos;
use Sigmalibre\Ingresos\IngresosSoftValidator;
use Sigmalibre\UnitsOfMeasurement\UnitsOfMeasurement;

/**
 * Realiza una importación de los datos provenientes desde la BD que utiliza
 * el programa PowerAcc, el cual utiliza la empresa para la cual fue diseñado
 * originalmente este proyecto, Esto es con el fin de ahorrarles el trabajo de
 * tener que ingresar uno por uno los miles de productos con los que su antiguo
 * sistema ya estaba trabajando.
 */
class ImportarProductos
{
    private $container;
    private $categoriasCreadas = 0;

    private $productosConError = [];

    public function __construct($container)
    {
        $this->container = $container;
    }

    private function obtenerDatosAImportar()
    {
        $listaDatos = new DataSource\MySQL\DatosProductosAImportar(new MySQLCustomDatabase('inventarios'));

        return $listaDatos->read([]);
    }

    private function obtenerDatosDesdeExcel()
    {
        $listaDatos = new DataSource\MySQL\DatosDesdeExcel(new MySQLCustomDatabase('trasladoinventario'));

        return $listaDatos->read([]);
    }

    private function prepararDatosAImportar()
    {
        $datos_importar = $this->obtenerDatosDesdeExcel();

        $datos_extra = $this->obtenerDatosAImportar();

        $extraAssoc = [];
        foreach ($datos_extra as $dato) {
            $extraAssoc[$dato['Codigo']] = $dato;
        }

        return array_map(function ($p) use ($extraAssoc) {
            $p['Categoria'] = empty($p['Categoria']) ? 'SINCATEGORIA' : $p['Categoria'];
            $p['Utilidad'] = empty($extraAssoc[$p['Codigo']]['Utilidad']) ? 0 : $extraAssoc[$p['Codigo']]['Utilidad'];
            $p['ReferenciaLibroDet'] = '03';
            $p['CodigoBienDet'] = '01';
            $p['Marca'] = empty($p['Marca']) ? 'SINMARCA' : $p['Marca'];
            $p['Medida'] = empty($p['Medida']) ? 'SINMEDIDA' : $p['Medida'];
            $p['Unidades'] = isset($p['Unidades']) ? $p['Unidades'] : 0;
            $p['Costo'] = isset($p['Costo']) ? $p['Costo'] : 0;

            return $p;
        }, $datos_importar);
    }

    /**
     * Para realizar el importe, se deben crear las categorías si estas no
     * existen.
     *
     * @param string $nombre Nombre de la categoría
     *
     * @return string Cógigo de la categoría creada
     */
    private function crearCategoria($nombre)
    {
        $buscadorCategorias = new Categories($this->container);

        // Si la categoría ingresada ya existe, utilizar esa.
        $idCategoria = $buscadorCategorias->idFromName($nombre);

        // Si la categoría no existe, crear una nueva.
        if ($idCategoria === false) {
            $idCategoria = $buscadorCategorias->save([
                'codigoCategoria' => sprintf('%02d', $this->categoriasCreadas++),
                'nombreCategoria' => $nombre,
            ]);
        }

        // Si no se pudo obtener la categoría, retorna false.
        return $idCategoria;
    }

    /**
     * Realiza una lectura desde la fuente de datos para obtener la lista
     * con los datos de los productos que desean ser creados por lotes y los
     * ingresa en la BD del sistema.
     *
     * @return bool True si se pudo realizar la importación, false de lo contrario
     *
     * @throws \RuntimeException Si la categoría no pudo ser creada
     */
    public function importar()
    {
        $productosPorCrear = $this->prepararDatosAImportar();

        $marcas = new Brands($this->container);
        $medidas = new UnitsOfMeasurement($this->container);

        foreach ($productosPorCrear as $index => $producto) {

            $producto = array_map('trim', $producto);

            if (strlen($producto['Categoria']) > 20) {
                $producto['Categoria'] = str_replace(' ', '', $producto['Categoria']);
                $producto['Categoria'] = substr($producto['Categoria'], 0, 20);
            }

            if (strlen($producto['Descripcion']) > 29) {
                $producto['Descripcion'] = substr($producto['Descripcion'], 0, 29);
            }

            $categoriaCreada = $this->crearCategoria($producto['Categoria']);

            // Revisar si la categoría no pudo ser creada
            if ($categoriaCreada === false) {
                $producto['RAZONERROR'] = 'La categoría "' . $producto['Categoria'] . '" no pudo ser creada.';
                $this->productosConError[] = $producto;
                continue;
            }

            // Revisar si el producto ya existe.
            $productoExistente = new ProductFromCode($producto['Codigo'], $this->container);

            // Si el producto no existe.
            if ($productoExistente->is_set() === false) {

                $creadorProductos = new Products($this->container);

                $seCreoProducto = $creadorProductos->save([
                    'codigoProducto' => $producto['Codigo'],
                    'descripcionProducto' => $producto['Descripcion'],
                    'stockMinProducto' => 1,
                    'utilidadProducto' => $producto['Utilidad'],
                    'referenciaLibroDetProducto' => $producto['ReferenciaLibroDet'],
                    'categoriaDetProducto' => $producto['CodigoBienDet'],
                    'marcaProducto' => $producto['Marca'],
                    'medidaProducto' => $producto['Medida'],
                    'categoriaProducto' => $categoriaCreada,
                ], $marcas, $medidas);

                // Revisar si el producto no fue creado.
                if ($seCreoProducto === false) {
                    $producto['RAZONERROR'] = 'El producto [' . $producto['Codigo'] . '] no pudo ser creado.';
                    $producto['ERRORES'] = $creadorProductos->getInvalidInputs();
                    $this->productosConError[] = $producto;
                    continue;
                }

                // El producto se creó.
                // Guardar costoInicial.
                $ingresos = new Ingresos($this->container, new IngresosSoftValidator());

                $isIngresoSaved = $ingresos->save([
                    'cantidadIngreso' => $producto['Unidades'],
                    'valorPrecioUnitario' => $producto['Costo'],
                    'valorCostoActualTotal' => $producto['Costo'], // El costo inicial es igual al unitario.
                    'empresaID' => null,
                    'almacenID' => 1, // Por defecto se elige el primer almacén que exista, si no existe la importación falla.
                ], $seCreoProducto);

                if ($isIngresoSaved === false) {
                    $producto['RAZONERROR'] = 'Se creó el producto, pero no se pudo establecer el costo inicial; Cantidad y Costo son cero.';
                    $producto['ERRORES'] = $ingresos->getInvalidInputs();
                    $this->productosConError[] = $producto;
                    continue;
                }
            }
        }

        return empty($this->productosConError);
    }

    public function getProductosConError()
    {
        return $this->productosConError;
    }
}
