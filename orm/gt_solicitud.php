<?php

namespace gamboamartin\gastos\models;

use base\orm\_modelo_parent_sin_codigo;
use base\orm\modelo;
use gamboamartin\errores\errores;
use gamboamartin\system\_ctl_parent_sin_codigo;
use PDO;
use stdClass;

class gt_solicitud extends _modelo_parent_sin_codigo
{
    public function __construct(PDO $link)
    {
        $tabla = 'gt_solicitud';
        $columnas = array($tabla => false, 'gt_tipo_solicitud' => $tabla, 'gt_centro_costo' => $tabla,
            'gt_tipo_centro_costo' => 'gt_centro_costo');
        $campos_obligatorios = array();

        $no_duplicados = array();


        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, no_duplicados: $no_duplicados);

        $this->NAMESPACE = __NAMESPACE__;
    }

    public function alta_bd(array $keys_integra_ds = array('codigo', 'descripcion')): array|stdClass
    {
        $acciones = $this->acciones_solicitante();
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al ejecutar acciones para el solicitante', data: $acciones);
        }

        $r_alta_bd = parent::alta_bd($keys_integra_ds);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al insertar solicitud', data: $r_alta_bd);
        }

        $acciones = $this->acciones_solicitantes(gt_solicitud_id: $r_alta_bd->registro_id, gt_solicitante_id: $acciones->registro_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al ejecutar acciones para el solicitante', data: $acciones);
        }

        return $r_alta_bd;
    }

    /**
     * Funcion que ejecuta acciones correspondientes a un solicitante
     * @return array|stdClass retorna el estado de la accion
     */
    public function acciones_solicitante() : array | stdClass
    {
        $existe = $this->existe_empleado_usuario(adm_usuario_id: $_SESSION['usuario_id']);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al comprobar si el usuario esta autorizado para hacer solicitudes',
                data: $existe);
        }

        if ($existe->n_registros <= 0) {
            return $this->error->error(mensaje: 'Error el usuario no cuenta con una relacion con un empleado autorizado',
                data: $existe);
        }

        $alta_solicitante = $this->alta_solicitante(em_empleado_id: $existe->registros[0]['em_empleado_id']);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error insertar una soliciante',
                data: $existe);
        }

        return $alta_solicitante;
    }

    /**
     * Funcion que ejecuta acciones correspondientes a la relacion entre una solicitud y un solicitante
     * @param int $gt_solicitud_id id de la solicitud
     * @param int $gt_solicitante_id id del solicitante
     * @return array|stdClass retorna el estado de la accion
     */
    public function acciones_solicitantes(int $gt_solicitud_id, int $gt_solicitante_id) : array | stdClass
    {
        $alta_solicitantes = $this->alta_solicitantes(gt_solicitud_id: $gt_solicitud_id, gt_solicitante_id: $gt_solicitante_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error insertar relacion solicitud - solicitante', data: $alta_solicitantes);
        }

        return $alta_solicitantes;
    }

    /**
     * Funcion que inserta un solicitante
     * @param int $em_empleado_id id del empleado
     * @return array|stdClass retorna el estado de la accion
     */
    public function alta_solicitante(int $em_empleado_id)
    {
        $registros['codigo'] = $this->get_codigo_aleatorio();
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error generar codigo', data: $registros);
        }
        $registros['descripcion'] = "Solicitud - solicitante";
        $registros['em_empleado_id'] = $em_empleado_id;

        $alta = (new gt_solicitante($this->link))->alta_registro(registro: $registros);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al dar de alta solicitante', data: $alta);
        }

        return $alta;
    }

    /**
     * Funcion que inserta la relacion entre una solicitud y un solicitante
     * @param int $gt_solicitud_id id de la solicitud
     * @param int $gt_solicitante_id id del solicitante
     * @return array|stdClass retorna el estado de la accion
     */
    public function alta_solicitantes(int $gt_solicitud_id, int $gt_solicitante_id)
    {
        $registros['codigo'] = $this->get_codigo_aleatorio();
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error generar codigo', data: $registros);
        }
        $registros['descripcion'] = "Solicitud - solicitante";
        $registros['gt_solicitud_id'] = $gt_solicitud_id;
        $registros['gt_solicitante_id'] = $gt_solicitante_id;

        $alta = (new gt_solicitantes($this->link))->alta_registro(registro: $registros);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al dar de alta relacion solicitud - solicitante', data: $alta);
        }

        return $alta;
    }

    /**
     * Funcion para validar si existe la relacion entre un empleado-usuario
     * @param int $adm_usuario_id id del usuario
     * @return array|stdClass retorna el estado de la accion
     */
    public function existe_empleado_usuario(int $adm_usuario_id): array|stdClass
    {
        $filtro['gt_empleado_usuario.adm_usuario_id'] = $adm_usuario_id;

        $data = (new gt_empleado_usuario($this->link))->filtro_and(filtro: $filtro);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al filtrar empleado usuario', data: $data);
        }

        return $data;
    }


    public function convierte_requisicion(int $gt_solicitud_id, int $gt_requision_id): array|stdClass
    {
        $alta = $this->alta_relacion_solicitud_requisicion(gt_solicitud_id: $gt_solicitud_id, gt_requision_id: $gt_requision_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error insertar relacion', data: $alta);
        }

        $productos = $this->solicitud_productos(gt_solicitud_id: $gt_solicitud_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al obtener productos', data: $productos);
        }

        $alta_productos = $this->alta_requisicion_productos(datos: $productos, gt_requision_id: $gt_requision_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al obtener productos', data: $productos);
        }

        return $alta_productos;
    }

    private function alta_relacion_solicitud_requisicion(int $gt_solicitud_id, int $gt_requision_id)
    {
        $registros['gt_solicitud_id'] = $gt_solicitud_id;
        $registros['gt_requisicion_id'] = $gt_requision_id;

        $alta = (new gt_solicitud_requisicion($this->link))->alta_registro(registro: $registros);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al dar de alta relacion solicitud requision', data: $alta);
        }

        return $alta;
    }

    public function solicitud_productos(int $gt_solicitud_id)
    {
        $filtro['gt_solicitud_producto.gt_solicitud_id'] = $gt_solicitud_id;

        $datos = (new gt_solicitud_producto($this->link))->filtro_and(filtro: $filtro);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al dar de alta relacion solicitud requision', data: $datos);
        }

        return $datos;
    }

    public function alta_requisicion_productos(stdClass $datos, int $gt_requision_id): array
    {
        $registros = $datos->registros;

        foreach ($registros as $registro) {
            $alta['gt_requisicion_id'] = $gt_requision_id;
            $alta['com_producto_id'] = $registro['com_producto_id'];
            $alta['cat_sat_unidad_id'] = $registro['cat_sat_unidad_id'];
            $alta['cantidad'] = $registro['gt_solicitud_producto_cantidad'];
            $alta['precio'] = $registro['com_producto_precio'];

            $alta = (new gt_requisicion_producto($this->link))->alta_registro(registro: $alta);
            if (errores::$error) {
                return $this->error->error(mensaje: 'Error al dar de alta requisicion producto', data: $alta);
            }
        }

        return $registros;
    }


}