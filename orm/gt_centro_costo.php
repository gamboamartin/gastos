<?php

namespace gamboamartin\gastos\models;

use base\orm\_modelo_parent;
use base\orm\modelo;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class gt_centro_costo extends _modelo_parent
{
    public function __construct(PDO $link)
    {
        $tabla = 'gt_centro_costo';
        $columnas = array($tabla => false, 'gt_tipo_centro_costo' => $tabla);
        $campos_obligatorios = array();

        $no_duplicados = array();


        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, no_duplicados: $no_duplicados);


        $this->NAMESPACE = __NAMESPACE__;

    }

    public function obtener_ordenes(int $gt_centro_costo_id): array|stdClass
    {
        $cotizaciones = $this->obtener_cotizaciones(gt_centro_costo_id: $gt_centro_costo_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al obtener cotizaciones', data: $cotizaciones);
        }

        return $cotizaciones->registros;
    }

    /**
     * Función para obtener cotizaciones filtradas por el ID de centro de costo.
     *
     * @param int $gt_centro_costo_id El ID del centro de costo.
     *
     * @return array|stdClass Retorna un array de cotizaciones o un objeto stdClass vacío.
     * Si se produce un error durante la filtración, se devuelve un objeto de error.
     */
    public function obtener_cotizaciones(int $gt_centro_costo_id): array|stdClass
    {
        $filtro['gt_cotizacion.gt_centro_costo_id'] = $gt_centro_costo_id;
        $cotizaciones = (new gt_cotizacion($this->link))->filtro_and(filtro: $filtro, limit: 2);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error filtrar cotizacion', data: $cotizaciones);
        }

        return $cotizaciones;
    }

    /**
     * Función para aplanar un array de datos y extraer los valores de una columna específica.
     *
     * @param array $datos El array de datos original con filas asociativas.
     * @param string $columna El nombre de la columna cuyos valores se desean extraer.
     *
     * @return array Retorna un array que contiene todos los valores de la columna especificada.
     */
    function aplanar(array $datos, string $columna) : array {
        $salida = array();

        foreach ($datos as $fila) {
            if (isset($fila[$columna])) {
                $salida[] = $fila[$columna];
            }
        }

        return $salida;
    }

}