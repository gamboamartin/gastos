<?php

namespace gamboamartin\gastos\models;

use base\orm\_modelo_parent;
use PDO;


class gt_autorizante extends _modelo_parent
{
    public function __construct(PDO $link)
    {
        $tabla = 'gt_autorizante';
        $columnas = array($tabla => false, "em_empleado" => $tabla);
        $campos_obligatorios = array();

        $no_duplicados = array();


        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, no_duplicados: $no_duplicados);

        $this->NAMESPACE = __NAMESPACE__;
    }

}