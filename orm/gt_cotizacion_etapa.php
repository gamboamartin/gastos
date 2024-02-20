<?php

namespace gamboamartin\gastos\models;

use gamboamartin\errores\errores;
use gamboamartin\proceso\models\pr_etapa_proceso;
use PDO;
use stdClass;

class gt_cotizacion_etapa extends _base_transacciones
{
    public function __construct(PDO $link)
    {
        $tabla = 'gt_cotizacion_etapa';
        $columnas = array($tabla => false, 'gt_cotizacion' => $tabla, 'pr_etapa_proceso' => $tabla,
            'pr_proceso' => 'pr_etapa_proceso', 'pr_etapa' => 'pr_etapa_proceso');
        $campos_obligatorios = array();

        $no_duplicados = array();


        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, no_duplicados: $no_duplicados);

        $this->NAMESPACE = __NAMESPACE__;
    }

    public function alta_bd(array $keys_integra_ds = array('codigo', 'descripcion')): array|stdClass
    {
        $r_alta_bd = parent::alta_bd($keys_integra_ds);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al insertar solicitud etapa', data: $r_alta_bd);
        }

        return $r_alta_bd;
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