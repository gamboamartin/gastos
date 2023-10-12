<?php

namespace gamboamartin\gastos\models;

use base\orm\modelo;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class gt_solicitantes extends modelo
{
    public function __construct(PDO $link)
    {
        $tabla = 'gt_solicitantes';
        $columnas = array($tabla => false, 'gt_solicitud' => $tabla, 'gt_solicitante' => $tabla, "em_empleado" => 'gt_solicitante');
        $campos_obligatorios = array();

        $no_duplicados = array();


        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, no_duplicados: $no_duplicados);

        $this->NAMESPACE = __NAMESPACE__;
    }


}