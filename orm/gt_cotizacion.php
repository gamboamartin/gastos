<?php

namespace gamboamartin\gastos\models;

use base\orm\_modelo_parent_sin_codigo;
use base\orm\modelo;
use gamboamartin\errores\errores;
use gamboamartin\system\_ctl_parent_sin_codigo;
use PDO;
use stdClass;

class gt_cotizacion extends _modelo_parent_sin_codigo
{
    public function __construct(PDO $link)
    {
        $tabla = 'gt_cotizacion';
        $columnas = array($tabla => false, 'gt_tipo_cotizacion' => $tabla, 'gt_centro_costo' => $tabla,
            'gt_tipo_centro_costo' => 'gt_centro_costo', 'gt_proveedor' => $tabla);
        $campos_obligatorios = array();

        $no_duplicados = array();


        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, no_duplicados: $no_duplicados);

        $this->NAMESPACE = __NAMESPACE__;
    }

    public function alta_bd(array $keys_integra_ds = array('codigo', 'descripcion')): array|stdClass
    {
        $gt_requisicion_id = $this->registro['gt_requisicion_id'];

        $acciones = $this->acciones_requisicion();
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al ejecutar acciones para requisicion', data: $acciones);
        }

        $r_alta_bd = parent::alta_bd($keys_integra_ds);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al insertar cotizacion', data: $r_alta_bd);
        }

        $relacon = $this->alta_relacion_requisicion_cotizacion(gt_requisicion_id: $gt_requisicion_id,
            gt_cotizacion_id: $r_alta_bd->registro_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al insertar relacion entre requisicion y cotizacion', data: $relacon);
        }

        return $r_alta_bd;
    }

    public function alta_relacion_requisicion_cotizacion(int $gt_requisicion_id, int $gt_cotizacion_id,): array|stdClass
    {
        $registros = array();
        $registros['gt_requisicion_id'] = $gt_requisicion_id;
        $registros['gt_cotizacion_id'] = $gt_cotizacion_id;
        $alta = (new gt_cotizacion_requisicion($this->link))->alta_registro(registro: $registros);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al ejecutar insercion de datos para requisicion y cotizacion',
                data: $alta);
        }

        return $alta;
    }

    public function acciones_requisicion(): array
    {
        $resultado = $this->verificar_estado_requisicion(registros: $this->registro);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al verificar etapa de la requisicion', data: $resultado);
        }

        $this->registro = $this->limpia_campos_extras(registro: $this->registro, campos_limpiar: array("gt_requisicion_id"));
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al limpiar campos', data: $this->registro);
        }

        return $this->registro;
    }

    public function verificar_estado_requisicion(array $registros): array|stdClass
    {
        $filtro['gt_requisicion_etapa.gt_requisicion_id'] = $registros['gt_requisicion_id'];
        $filtro['gt_requisicion.etapa'] = "AUTORIZADO";
        $etapa = (new gt_requisicion_etapa($this->link))->filtro_and(filtro: $filtro);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al filtrar etapa de la requisicion', data: $etapa);
        }

        if ($etapa->n_registros <= 0) {
            return $this->error->error(mensaje: 'Error la requisicion no se encuentra AUTORIZADA', data: $etapa);
        }

        return $etapa;
    }

}