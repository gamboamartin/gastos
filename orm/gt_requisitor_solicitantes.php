<?php

namespace gamboamartin\gastos\models;

use base\orm\_modelo_parent;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class gt_requisitor_solicitantes extends _base_auto_soli
{
    public function __construct(PDO $link)
    {
        $tabla = 'gt_requisitor_solicitantes';
        $columnas = array($tabla => false, 'gt_requisitor' => $tabla, 'gt_solicitante' => $tabla);
        $campos_obligatorios = array();

        $no_duplicados = array();

        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, no_duplicados: $no_duplicados);

        $this->NAMESPACE = __NAMESPACE__;
    }

    protected function inicializa_campos(array $registros): array
    {
        $registros['codigo'] = $this->get_codigo_aleatorio();
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error generar codigo', data: $registros);
        }

        $registros['descripcion'] = $registros['codigo'];

        return $registros;
    }

}