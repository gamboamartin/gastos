<?php
namespace gamboamartin\gastos\models;

use base\orm\_modelo_parent_sin_codigo;
use gamboamartin\errores\errores;
use PDO;
use stdClass;


class gt_orden_compra extends _modelo_parent_sin_codigo {
    public function __construct(PDO $link){
        $tabla = 'gt_orden_compra';
        $columnas = array($tabla=>false, "gt_tipo_orden_compra" => $tabla);
        $campos_obligatorios = array();

        $no_duplicados = array();


        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas,no_duplicados: $no_duplicados);

        $this->NAMESPACE = __NAMESPACE__;
    }

    public function genera_orden_compra(int $gt_cotizacion_id) : array|stdClass
    {
        $productos = $this->cotizacion_productos(gt_cotizacion_id: $gt_cotizacion_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al obtener productos', data: $productos);
        }

        $alta_productos = $this->alta_orden_productos(datos: $productos, gt_cotizacion_id: $gt_cotizacion_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al obtener productos', data: $productos);
        }

        return $alta_productos;
    }

    public function cotizacion_productos(int $gt_cotizacion_id)
    {
        $filtro['gt_cotizacion_producto.gt_cotizacion_id'] = $gt_cotizacion_id;

        $datos = (new gt_cotizacion_producto($this->link))->filtro_and(filtro: $filtro);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error obtener productos de la cotizacion', data: $datos);
        }

        return $datos;
    }

    public function alta_orden_productos(stdClass $datos, int $gt_cotizacion_id) : array
    {
        $descripcion =  $this->get_codigo_aleatorio();

        $alta_orden = $this->alta_orden_compra(descripcion: $descripcion);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error insertar orden compra', data: $alta_orden);
        }

        $alta_relacion = $this->alta_relacion_orden_compra_cotizacion(gt_cotizacion_id: $gt_cotizacion_id,
            gt_orden_compra_id: $alta_orden->registro_id, descripcion: $descripcion);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error insertar relacion orden compra cotizacion', data: $alta_relacion);
        }

        $registros = $datos->registros;

        foreach ($registros as $registro){
            $alta['gt_orden_compra_id'] = $alta_orden->registro_id;
            $alta['com_producto_id'] = $registro['com_producto_id'];
            $alta['cat_sat_unidad_id'] = $registro['cat_sat_unidad_id'];
            $alta['cantidad'] = $registro['gt_solicitud_producto_cantidad'];
            $alta['precio'] = $registro['com_producto_precio'];

            $alta = (new gt_orden_compra_producto($this->link))->alta_registro(registro: $alta);
            if (errores::$error) {
                return $this->error->error(mensaje: 'Error al dar de alta orden compra producto', data: $alta);
            }
        }

        return $registros;
    }

    private function alta_orden_compra(string $descripcion)
    {
        $registros['descripcion'] = $descripcion;

        $alta = (new gt_orden_compra($this->link))->alta_registro(registro: $registros);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al dar de alta orden compra', data: $alta);
        }

        return $alta;
    }

    private function alta_relacion_orden_compra_cotizacion(int $gt_cotizacion_id, int $gt_orden_compra_id, string $descripcion)
    {
        $registros['gt_cotizacion_id'] = $gt_cotizacion_id;
        $registros['gt_orden_compra_id'] = $gt_orden_compra_id;
        $registros['descripcion'] = $descripcion;

        $alta = (new gt_orden_compra_cotizacion($this->link))->alta_registro(registro: $registros);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al dar de alta relacion orden compra cotizacion', data: $alta);
        }

        return $alta;
    }
}