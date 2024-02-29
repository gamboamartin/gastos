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

    public function obtener_cotizaciones(int $gt_centro_costo_id): array|stdClass
    {
        $filtro['gt_cotizacion.gt_centro_costo_id'] = $gt_centro_costo_id;
        $cotizaciones = (new gt_cotizacion($this->link))->filtro_and(filtro: $filtro);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error filtrar cotizacion', data: $cotizaciones);
        }

        return $cotizaciones;
    }
}