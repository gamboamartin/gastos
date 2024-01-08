<?php

namespace gamboamartin\gastos\models;

use gamboamartin\errores\errores;
use PDO;
use stdClass;

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

    public function get_precio_promedio(int $com_producto_id)
    {
        $productos = $this->get_productos(com_producto_id: $com_producto_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al obtener productos', data: $productos);
        }

        $promedio = $this->promedio_precios_productos(productos: $productos);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al calcular el promedio de precios de los productos', data: $promedio);
        }

        return $promedio;
    }

    public function get_productos(int $com_producto_id)
    {
        $filtro['gt_solicitud_producto.com_producto_id'] = $com_producto_id;

        $datos = (new gt_solicitud_producto($this->link))->filtro_and(filtro: $filtro);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al aplicar filtro para productos', data: $datos);
        }

        return $datos;
    }

    public function promedio_precios_productos(stdClass $productos) : float
    {
        if ($productos->n_registros <= 0) {
            return 0.0;
        }

        $promedio = 0.0;
        $registros = $productos->registros;

        foreach ($registros as $registro){
            $promedio += $registro['gt_solicitud_producto_precio'];
        }

        return round($promedio / $productos->n_registros, 2);
    }
}