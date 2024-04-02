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

        $acciones_cotizador = $this->acciones_cotizador();
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al ejecutar acciones para el cotizador', data: $acciones_cotizador);
        }


        $r_alta_bd = parent::alta_bd($keys_integra_ds);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al insertar cotizacion', data: $r_alta_bd);
        }

        return $r_alta_bd;
    }

    public function acciones_cotizador() : array | stdClass
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
            return $this->error->error(mensaje: 'Error al comprobar si el usuario esta autorizado para hacer cotizaciones',
                data: $existe);
        }

        if ($existe->n_registros <= 0) {
            return $this->error->error(mensaje: 'Error el usuario no se encuentra autorizado para hacer cotizaciones',
                data: $existe);
        }

        return $existe;
    }

    public function validar_permiso_empleado(int $em_empleado_id)
    {
        $existe = Transaccion::of(new gt_cotizador($this->link))
            ->existe(filtro: ['gt_cotizador.em_empleado_id' => $em_empleado_id]);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al comprobar si el empleado esta autorizado para hacer cotizaciones',
                data: $existe);
        }

        if ($existe->n_registros <= 0) {
            return $this->error->error(mensaje: 'Error el empleado no es un cotizador autorizado',
                data: $existe);
        }

        return $existe;
    }



}