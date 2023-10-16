<?php

namespace gamboamartin\gastos\models;

use PDO;

class gt_empleado_usuario extends _base_transacciones
{
    public function __construct(PDO $link)
    {
        $tabla = 'gt_empleado_usuario';
        $columnas = array($tabla => false, "em_empleado" => $tabla);
        $campos_obligatorios = array();

        $no_duplicados = array();


        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, no_duplicados: $no_duplicados);

        $this->NAMESPACE = __NAMESPACE__;
    }
}