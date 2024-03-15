<?php

namespace gamboamartin\gastos\models;

use base\orm\_modelo_parent;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class gt_proveedor extends _modelo_parent
{
    public function __construct(PDO $link)
    {
        $tabla = 'gt_proveedor';
        $columnas = array($tabla => false, 'cat_sat_regimen_fiscal' => $tabla, 'gt_tipo_proveedor' => $tabla,
            'dp_calle_pertenece' => $tabla, 'dp_colonia_postal' => 'dp_calle_pertenece', 'dp_cp' => 'dp_colonia_postal',
            'dp_municipio' => 'dp_cp', 'dp_estado' => 'dp_municipio', 'dp_pais' => 'dp_estado');
        $campos_obligatorios = array('gt_tipo_proveedor_id', 'dp_calle_pertenece_id', 'cat_sat_regimen_fiscal_id',
            'rfc', 'exterior', 'telefono_1', 'contacto_1', 'pagina_web');

        $no_duplicados = array();

        $tipo_campos['telefono_1'] = 'telefono_mx';
        $tipo_campos['telefono_2'] = 'telefono_mx';
        $tipo_campos['telefono_3'] = 'telefono_mx';


        parent::__construct(link: $link, tabla: $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas, no_duplicados: $no_duplicados, tipo_campos: $tipo_campos);

        $this->NAMESPACE = __NAMESPACE__;
    }

    public function alta_bd(array $keys_integra_ds = array('codigo', 'descripcion')): array|stdClass
    {
        $this->registro = $this->inicializa_campos($this->registro);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al inicializar campo base', data: $this->registro);
        }

        $r_alta_bd = parent::alta_bd($keys_integra_ds);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al insertar autorizante', data: $r_alta_bd);
        }
        return $r_alta_bd;
    }

    protected function inicializa_campos(array $registros): array
    {
        $keys = array('dp_calle_pertenece_id', 'cat_sat_regimen_fiscal_id', 'gt_tipo_proveedor_id');
        $valida = $this->validacion->valida_ids(keys: $keys, registro: $registros);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error validar campos', data: $valida);
        }

        $registros['codigo'] = $this->get_codigo_aleatorio();
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error generar codigo', data: $registros);
        }

        $registros['codigo'] .= " - " . $registros['rfc'];
        $registros['descripcion'] = $registros['razon_social'];

        return $registros;
    }

    public function modifica_bd(array $registro, int $id, bool $reactiva = false,
                                array $keys_integra_ds = array('codigo', 'descripcion')): array|stdClass
    {
        $registro = $this->inicializa_campos(registros: $registro);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al inicializar campo base', data: $registro);
        }

        $r_modifica_bd = parent::modifica_bd($registro, $id, $reactiva, $keys_integra_ds);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al modificar autorizante', data: $r_modifica_bd);
        }
        return $r_modifica_bd;
    }

    public function getProductoTotal($id)
    {

        $campos = array("gt_cotizacion_producto_total");
        $filtro = ['gt_cotizacion_producto.gt_cotizacion_id' => $id];
        $datos = (new gt_cotizacion_producto($this->link))->filtro_and(
            columnas: $campos,
            filtro: $filtro
        );
        if (errores::$error) {
            return $this->error->error('Error al obtener los datos de la cotizacion', $datos);
        }

        return Stream::of($datos->registros)
            ->map(fn($registro) => $registro['gt_cotizacion_producto_total'])
            ->toArray();
    }

    public function total_saldos_cotizacion(int $gt_proveedor_id): array|stdClass
    {
        $cotizaciones = Transaccion::getInstance(new gt_cotizacion($this->link), $this->error)
            ->get_registros('gt_proveedor_id', $gt_proveedor_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al obtener cotizaciones', data: $cotizaciones);
        }

        $total_alta = Stream::of($cotizaciones->registros)
            ->filter(fn($registro) => $registro['gt_cotizacion_etapa'] === 'ALTA')
            ->map(fn($registro) => $registro['gt_cotizacion_id'])
            ->flatMap(fn($id) => $this->getProductoTotal($id))
            ->reduce(fn($acumulador, $valor) => $acumulador + $valor, 0.0);

        $total_autorizado = Stream::of($cotizaciones->registros)
            ->filter(fn($registro) => $registro['gt_cotizacion_etapa'] === 'AUTORIZADO')
            ->map(fn($registro) => $registro['gt_cotizacion_id'])
            ->flatMap(fn($id) => $this->getProductoTotal($id))
            ->reduce(fn($acumulador, $valor) => $acumulador + $valor, 0.0);

        $total_cotizacion = [
            "total_alta" => $total_alta,
            "total_autorizado" => $total_autorizado,
            "total" => $total_alta + $total_autorizado,
        ];

        return $total_cotizacion;
    }


    public function obtener_orden_compra_cotizacion2(int $gt_cotizacion_id): int
    {
        $filtro = ['gt_orden_compra_cotizacion.gt_cotizacion_id' => $gt_cotizacion_id];
        $orden = (new gt_orden_compra_cotizacion($this->link))->filtro_and(
            columnas: ['gt_orden_compra_id'],
            filtro: $filtro
        );
        if (errores::$error) {
            return $this->error->error('Error filtrar orden compra cotizacion', $orden);
        }

        return Stream::of($orden->registros)
            ->map(fn($registro) => $registro['gt_orden_compra_id'])
            ->findFirst() ?? -1;
    }

    public function getProductoTotal2($id)
    {
        $campos = array("gt_orden_compra_producto_total");
        $filtro = ['gt_orden_compra_producto.gt_orden_compra_id' => $id];
        $datos = (new gt_orden_compra_producto($this->link))->filtro_and(
            columnas: $campos,
            filtro: $filtro
        );
        if (errores::$error) {
            return $this->error->error('Error al obtener los datos de la orden de compra', $datos);
        }

        return Stream::of($datos->registros)
            ->map(fn($registro) => $registro['gt_orden_compra_producto_total'])
            ->toArray();
    }


    /**
     * Función para calcular el total de saldos de orden de compra en un proceso.
     *
     * @param int $gt_proveedor_id El ID del proveedor.
     *
     * @return array|stdClass Retorna un array con el total de las ordenes de compra en alta y autorizadas.
     * Si se produce un error durante la obtención de los datos, se devuelve un objeto de error.
     */
    public function total_saldos_orden_compra(int $gt_proveedor_id): array|stdClass
    {
        $cotizaciones = Transaccion::getInstance(new gt_cotizacion($this->link), $this->error)
            ->get_registros('gt_proveedor_id', $gt_proveedor_id);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al obtener cotizaciones', data: $cotizaciones);
        }

        $total_alta = Stream::of($cotizaciones->registros)
            ->filter(fn($registro) => $registro['gt_cotizacion_etapa'] === 'ALTA')
            ->map(fn($registro) => $registro['gt_cotizacion_id'])
            ->flatMap(fn($cotizacion_id) => $this->obtener_orden_compra_cotizacion2($cotizacion_id))
            ->filter(fn($orden_compra_id) => $orden_compra_id > -1)
            ->flatMap(fn($id) => $this->getProductoTotal2($id))
            ->reduce(fn($acumulador, $valor) => $acumulador + $valor, 0.0);

        $total_autorizado = Stream::of($cotizaciones->registros)
            ->filter(fn($registro) => $registro['gt_cotizacion_etapa'] === 'AUTORIZADO')
            ->map(fn($registro) => $registro['gt_cotizacion_id'])
            ->flatMap(fn($cotizacion_id) => $this->obtener_orden_compra_cotizacion2($cotizacion_id))
            ->filter(fn($orden_compra_id) => $orden_compra_id > -1)
            ->flatMap(fn($id) => $this->getProductoTotal2($id))
            ->reduce(fn($acumulador, $valor) => $acumulador + $valor, 0.0);

        $total_orden_compra = [
            "total_alta" => $total_alta,
            "total_autorizado" => $total_autorizado,
            "total" => $total_alta + $total_autorizado,
        ];

        return $total_orden_compra;
    }

}