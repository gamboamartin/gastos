<?php

namespace gamboamartin\gastos\models;

use base\orm\_modelo_parent_sin_codigo;
use base\orm\modelo;
use gamboamartin\errores\errores;
use gamboamartin\system\_ctl_parent_sin_codigo;
use PDO;
use stdClass;

class gt_solicitud extends _modelo_parent_sin_codigo
{
    public function __construct(PDO $link)
    {
        $tabla = 'gt_solicitud';
        $columnas = array($tabla => false, 'gt_tipo_solicitud' => $tabla, 'gt_centro_costo' => $tabla,
            'gt_tipo_centro_costo' => 'gt_centro_costo');
        $campos_obligatorios = array();

        $no_duplicados = array();


        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, no_duplicados: $no_duplicados);

        $this->NAMESPACE = __NAMESPACE__;
    }

    public function convierte_requisicion(int $gt_requision_id) : array|stdClass
    {
        $alta = $this->alta_relacion_solicitud_requisicion(gt_requision_id: $gt_requision_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error insertar relacion', data: $alta);
        }

        return $alta;
    }

    private function alta_relacion_solicitud_requisicion(int $gt_requision_id)
    {
        $registros['gt_solicitud_id'] = $this->registro_id;
        $registros['gt_requisicion_id'] = $gt_requision_id;

        $alta = (new gt_solicitud_requisicion($this->link))->alta_registro(registro: $registros);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al dar de alta relacion solicitud requision', data: $alta);
        }

        return $alta;
    }



}