<?php

namespace gamboamartin\gastos\models;

use gamboamartin\errores\errores;
use PDO;
use stdClass;

class gt_autorizante extends _base_transacciones
{
    public function __construct(PDO $link)
    {
        $tabla = 'gt_autorizante';
        $columnas = array($tabla => false, "em_empleado" => $tabla);
        $campos_obligatorios = array();

        $no_duplicados = array();

        $columnas_extra['em_empleado_nombre_completo'] = 'CONCAT (IFNULL(em_empleado.nombre,"")," ",IFNULL(em_empleado.ap, "")," ",IFNULL(em_empleado.am,""))';

        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, columnas_extra: $columnas_extra, no_duplicados: $no_duplicados);

        $this->NAMESPACE = __NAMESPACE__;
    }

    public function alta_bd(array $keys_integra_ds = array('codigo', 'descripcion')): array|stdClass
    {
        $procesos_seleccionados = explode(",", $_POST['pr_procesos']);

        $r_alta_bd = parent::alta_bd($keys_integra_ds);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al insertar autorizante', data: $r_alta_bd);
        }
        return $r_alta_bd;
    }

    protected function inicializa_campos(array $registros): array
    {
        if (!isset($registros['codigo'])){
            $registros['codigo'] = $this->get_codigo_aleatorio();
            if (errores::$error) {
                return $this->error->error(mensaje: 'Error generar codigo', data: $registros);
            }
        }

        $init = parent::inicializa_campos($registros);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error inicializar campos', data: $init);
        }

        return $init;
    }
}