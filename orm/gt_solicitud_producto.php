<?php

namespace gamboamartin\gastos\models;

use gamboamartin\errores\errores;
use PDO;

class gt_solicitud_producto extends _base_transacciones
{
    public function __construct(PDO $link)
    {
        $tabla = 'gt_solicitud_producto';
        $columnas = array($tabla => false, 'gt_solicitud' => $tabla, 'com_producto' => $tabla, 'cat_sat_unidad' => $tabla);
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