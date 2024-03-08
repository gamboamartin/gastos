<?php

namespace gamboamartin\gastos\models;

use base\orm\_modelo_parent;
use base\orm\modelo;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class gt_centro_costo extends _modelo_parent
{
    public function __construct(PDO $link)
    {
        $tabla = 'gt_centro_costo';
        $columnas = array($tabla => false, 'gt_tipo_centro_costo' => $tabla);
        $campos_obligatorios = array();

        $no_duplicados = array();


        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, no_duplicados: $no_duplicados);


        $this->NAMESPACE = __NAMESPACE__;

    }

    /**
     * Función para aplanar un array de datos y extraer los valores de una columna específica.
     *
     * @param array $datos El array de datos original con filas asociativas.
     * @param string $columna El nombre de la columna cuyos valores se desean extraer.
     *
     * @return array Retorna un array que contiene todos los valores de la columna especificada.
     */
    function aplanar(array $datos, string $columna): array
    {
        return array_column(array_filter($datos, function ($fila) use ($columna) {
            return isset($fila[$columna]);
        }), $columna);
    }

    /**
     * Función para obtener cotizaciones filtradas por el ID de centro de costo.
     *
     * @param int $gt_centro_costo_id El ID del centro de costo.
     *
     * @return array|stdClass Retorna un array de cotizaciones o un objeto stdClass vacío.
     * Si se produce un error durante la filtración, se devuelve un objeto de error.
     */
    public function obtener_cotizaciones(int $gt_centro_costo_id): array|stdClass
    {
        $filtro['gt_cotizacion.gt_centro_costo_id'] = $gt_centro_costo_id;
        $cotizaciones = (new gt_cotizacion($this->link))->filtro_and(filtro: $filtro);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error filtrar cotizacion', data: $cotizaciones);
        }

        return $cotizaciones;
    }

    /**
     * Función para obtener solicitudes filtradas por el ID de centro de costo.
     *
     * @param int $gt_centro_costo_id El ID del centro de costo.
     *
     * @return array|stdClass Retorna un array de solicitudes o un objeto stdClass vacío.
     * Si se produce un error durante la filtración, se devuelve un objeto de error.
     */
    public function obtener_solicitudes(int $gt_centro_costo_id): array|stdClass
    {
        $filtro['gt_solicitud.gt_centro_costo_id'] = $gt_centro_costo_id;
        $solicitudes = (new gt_solicitud($this->link))->filtro_and(filtro: $filtro);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error filtrar solicitud', data: $solicitudes);
        }

        return $solicitudes;
    }

    public function obtener_requisiciones(int $gt_centro_costo_id): array|stdClass
    {
        $filtro['gt_requisicion.gt_centro_costo_id'] = $gt_centro_costo_id;
        $requisiciones = (new gt_requisicion($this->link))->filtro_and(filtro: $filtro);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error filtrar requisicion', data: $requisiciones);
        }

        return $requisiciones;
    }

    /**
     * Función para obtener el ID de la orden de compra asociada a una cotización.
     *
     * @param int $gt_cotizacion_id El ID de la cotización.
     *
     * @return array|stdClass|int Retorna el ID de la orden de compra o un objeto stdClass vacío.
     * Si no se encuentra una orden de compra, se devuelve -1.
     * Si se produce un error durante la consulta, se devuelve un objeto de error.
     */
    public function obtener_orden_compra_cotizacion(int $gt_cotizacion_id): array|stdClass|int
    {
        $filtro = ['gt_orden_compra_cotizacion.gt_cotizacion_id' => $gt_cotizacion_id];
        $orden = (new gt_orden_compra_cotizacion($this->link))->filtro_and(
            columnas: ['gt_orden_compra_id'],
            filtro: $filtro
        );
        if (errores::$error) {
            return $this->error->error('Error filtrar orden compra cotizacion', $orden);
        }

        $registro = $orden->registros[0] ?? null;

        return $registro ? $registro['gt_orden_compra_id'] : -1;
    }

    /**
     * Función para obtener el total de las ordenes de compra asociadas a cotizaciones de un centro de costo.
     *
     * @param int $gt_centro_costo_id El ID del centro de costo.
     *
     * @return array|stdClass|float Retorna el total de productos en todas las cotizaciones
     * En caso de error, se devuelve un array, stdClass o el resultado de un error, según corresponda.
     */
    public function total_ordenes_cotizacion(int $gt_centro_costo_id): array|stdClass|float
    {
        $cotizaciones = $this->obtener_cotizaciones(gt_centro_costo_id: $gt_centro_costo_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al obtener cotizaciones', data: $cotizaciones);
        }

        $aplanados = $this->aplanar($cotizaciones->registros, "gt_cotizacion_id");
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al aplanar datos por gt_cotizacion_id', data: $aplanados);
        }

        $total = 0.0;

        foreach ($aplanados as $elemento) {
            $gt_orden_compra_id = $this->obtener_orden_compra_cotizacion(gt_cotizacion_id: $elemento);
            if (errores::$error) {
                return $this->error->error(mensaje: 'Error al obtener gt_orden_compra_id', data: $gt_orden_compra_id);
            }

            if ($gt_orden_compra_id > -1) {
                $suma = $this->suma_productos_orden_compra(gt_orden_compra_id: $gt_orden_compra_id);
                if (errores::$error) {
                    return $this->error->error(mensaje: 'Error al totales de productos de la orden de compra', data: $suma);
                }

                $total += $suma;
            }
        }

        return round(num: $total, precision: 2);
    }

    /**
     * Función para calcular el total de productos en todas las solicitudes asociadas a un centro de costo.
     *
     * @param int $gt_centro_costo_id El ID del centro de costo.
     *
     * @return array|stdClass|float Retorna el total de productos en todas las solicitudes
     * En caso de error, se devuelve un array, stdClass o el resultado de un error, según corresponda.
     */
    public function total_solicitud(int $gt_centro_costo_id): array|stdClass|float
    {
        $solicitudes= $this->obtener_solicitudes(gt_centro_costo_id: $gt_centro_costo_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al obtener solicitudes', data: $solicitudes);
        }

        $aplanados = $this->aplanar($solicitudes->registros, "gt_solicitud_id");
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al aplanar datos por gt_solicitud_id', data: $aplanados);
        }

        $total = 0.0;

        foreach ($aplanados as $elemento) {
            $suma = $this->suma_productos_solicitud(gt_solicitud_id: $elemento);
            if (errores::$error) {
                return $this->error->error(mensaje: 'Error al totales de productos de la solicitud', data: $suma);
            }

            $total += $suma;
        }

        return round(num: $total, precision: 2);
    }

    public function total_requisicion(int $gt_centro_costo_id): array|stdClass|float
    {
        $requisiciones = $this->obtener_requisiciones(gt_centro_costo_id: $gt_centro_costo_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al obtener solicitudes', data: $requisiciones);
        }

        $aplanados = $this->aplanar($requisiciones->registros, "gt_requisicion_id");
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al aplanar datos por gt_requisicion_id', data: $aplanados);
        }

        $total = 0.0;

        foreach ($aplanados as $elemento) {
            $suma = $this->suma_productos_requisicion(gt_requisicion_id: $elemento);
            if (errores::$error) {
                return $this->error->error(mensaje: 'Error al totales de productos de la requisicion', data: $suma);
            }

            $total += $suma;
        }

        return round(num: $total, precision: 2);
    }

    /**
     * Función para calcular la suma total de los productos asociados a una orden de compra.
     *
     * @param int $gt_orden_compra_id El ID de la orden de compra.
     *
     * @return array|stdClass|float Retorna la suma total de los productos de la orden de compra.
     * Si se produce un error durante la obtención o suma de los datos, se devuelve un objeto de error.
     */
    public function suma_productos_orden_compra(int $gt_orden_compra_id): array|stdClass|float
    {
        $campos = array("gt_orden_compra_producto_total");
        $filtro = ['gt_orden_compra_producto.gt_orden_compra_id' => $gt_orden_compra_id];
        $datos = (new gt_orden_compra_producto($this->link))->filtro_and(
            columnas: $campos,
            filtro: $filtro
        );
        if (errores::$error) {
            return $this->error->error('Error al obtener los datos de la orden de compra', $datos);
        }

        $suma = $this->sumar(datos: $datos->registros, columna: "gt_orden_compra_producto_total");
        if (errores::$error) {
            return $this->error->error('Error al sumar valores', $suma);
        }

        return round(num: $suma, precision: 2);
    }

    /**
     * Función para calcular la suma total de los productos asociados a una solicitud.
     *
     * @param int $gt_solicitud_id El ID de la solicitud.
     *
     * @return array|stdClass|float Retorna la suma total de los productos de la solicitud.
     * Si se produce un error durante la obtención o suma de los datos, se devuelve un objeto de error.
     */
    public function suma_productos_solicitud(int $gt_solicitud_id): array|stdClass|float
    {
        $campos = array("gt_solicitud_producto_total");
        $filtro = ['gt_solicitud_producto.gt_solicitud_id' => $gt_solicitud_id];
        $datos = (new gt_solicitud_producto($this->link))->filtro_and(
            columnas: $campos,
            filtro: $filtro
        );
        if (errores::$error) {
            return $this->error->error('Error al obtener los datos de la solicitud', $datos);
        }

        $suma = $this->sumar(datos: $datos->registros, columna: "gt_solicitud_producto_total");
        if (errores::$error) {
            return $this->error->error('Error al sumar valores', $suma);
        }

        return round(num: $suma, precision: 2);
    }

    public function suma_productos_requisicion(int $gt_requisicion_id): array|stdClass|float
    {
        $campos = array("gt_requisicion_producto_total");
        $filtro = ['gt_requisicion_producto.gt_requisicion_id' => $gt_requisicion_id];
        $datos = (new gt_requisicion_producto($this->link))->filtro_and(
            columnas: $campos,
            filtro: $filtro
        );
        if (errores::$error) {
            return $this->error->error('Error al obtener los datos de la requisicion', $datos);
        }

        $suma = $this->sumar(datos: $datos->registros, columna: "gt_requisicion_producto_total");
        if (errores::$error) {
            return $this->error->error('Error al sumar valores', $suma);
        }

        return round(num: $suma, precision: 2);
    }

    /**
     * Función para sumar los valores de una columna en un array de datos.
     *
     * @param array $datos El array de datos del cual se sumarán los valores.
     * @param string $columna El nombre de la columna cuyos valores se sumarán.
     *
     * @return float Retorna la suma de los valores de la columna especificada.
     */
    function sumar(array $datos, string $columna): float
    {
        $valores = $this->aplanar(datos: $datos, columna: $columna);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al aplanar datos por $columna', data: $valores);
        }

        return round(num: array_sum($valores), precision: 2);
    }

}