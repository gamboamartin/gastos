<?php

namespace gamboamartin\gastos\models;

use base\orm\_modelo_parent_sin_codigo;
use base\orm\modelo;
use gamboamartin\errores\errores;
use gamboamartin\system\_ctl_parent_sin_codigo;
use PDO;
use stdClass;

class gt_requisicion extends _modelo_parent_sin_codigo
{
    public function __construct(PDO $link)
    {
        $tabla = 'gt_requisicion';
        $columnas = array($tabla => false, 'gt_tipo_requisicion' => $tabla, 'gt_centro_costo' => $tabla,
            'gt_tipo_centro_costo' => 'gt_centro_costo');
        $campos_obligatorios = array();

        $no_duplicados = array();


        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, no_duplicados: $no_duplicados);

        $this->NAMESPACE = __NAMESPACE__;
    }

    public function alta_bd(array $keys_integra_ds = array('codigo', 'descripcion')): array|stdClass
    {
        $gt_solicitud_id = $this->registro['gt_solicitud_id'];

        $acciones_requisitor = $this->acciones_requisitor();
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al ejecutar acciones para el requisitor', data: $acciones_requisitor);
        }

        $acciones = $this->acciones_solicitud();
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al ejecutar acciones para solicitud', data: $acciones);
        }

        $r_alta_bd = parent::alta_bd($keys_integra_ds);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al insertar requisicion', data: $r_alta_bd);
        }

        $relacon = $this->alta_relacion_solicitud_requisicion(gt_solicitud_id: $gt_solicitud_id,
            gt_requisicion_id: $r_alta_bd->registro_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al insertar relacion entre solicitud y requisicion', data: $relacon);
        }

        return $r_alta_bd;
    }

    public function alta_relacion_solicitud_requisicion(int $gt_solicitud_id, int $gt_requisicion_id): array|stdClass
    {
        $registros = array();
        $registros['gt_solicitud_id'] = $gt_solicitud_id;
        $registros['gt_requisicion_id'] = $gt_requisicion_id;
        $alta = (new gt_solicitud_requisicion($this->link))->alta_registro(registro: $registros);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al ejecutar insercion de datos para solicitud y requisicion', data: $alta);
        }

        return $alta;
    }

    public function acciones_solicitud(): array
    {
        $resultado = $this->verificar_estado_solicitud(registros: $this->registro);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al verificar etapa de la solicitud', data: $resultado);
        }

        $this->registro = $this->limpia_campos_extras(registro: $this->registro, campos_limpiar: array("gt_solicitud_id"));
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al limpiar campos', data: $this->registro);
        }

        return $this->registro;
    }

    public function acciones_requisitor() : array | stdClass
    {
        $existe_usuario = $this->validar_permiso_usuario();
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al comprobar permisos del usuario', data: $existe_usuario);
        }

        $existe_solicitante = $this->validar_permiso_empleado($existe_usuario->registros[0]['em_empleado_id']);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al comprobar permisos del empleado',
                data: $existe_solicitante);
        }

        return $existe_solicitante;
    }

    public function validar_permiso_usuario()
    {
        $existe = Transaccion::of(new gt_empleado_usuario($this->link))
            ->existe(filtro: ['gt_empleado_usuario.adm_usuario_id' => $_SESSION['usuario_id']]);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al comprobar si el usuario esta autorizado para hacer requisiciones',
                data: $existe);
        }

        if ($existe->n_registros <= 0) {
            return $this->error->error(mensaje: 'Error el usuario no se encuentra autorizado para hacer requisiciones',
                data: $existe);
        }

        return $existe;
    }

    public function validar_permiso_empleado(int $em_empleado_id)
    {
        $existe = Transaccion::of(new gt_requisitor($this->link))
            ->existe(filtro: ['gt_requisitor.em_empleado_id' => $em_empleado_id]);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al comprobar si el empleado esta autorizado para hacer requisiciones',
                data: $existe);
        }

        if ($existe->n_registros <= 0) {
            return $this->error->error(mensaje: 'Error el empleado no es un requisitor autorizado',
                data: $existe);
        }

        return $existe;
    }

    public function verificar_estado_solicitud(array $registros): array|stdClass
    {
        $filtro['gt_solicitud_etapa.gt_solicitud_id'] = $registros['gt_solicitud_id'];
        $filtro['gt_solicitud.etapa'] = "AUTORIZADO";
        $etapa = (new gt_solicitud_etapa($this->link))->filtro_and(filtro: $filtro);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al filtrar etapa de la solicitud', data: $etapa);
        }

        if ($etapa->n_registros <= 0) {
            return $this->error->error(mensaje: 'Error la solicitud no se encuentra AUTORIZADA', data: $etapa);
        }

        return $etapa;
    }


}