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
        $keys = array('dp_calle_pertenece_id','cat_sat_regimen_fiscal_id','gt_tipo_proveedor_id');
        $valida = $this->validacion->valida_ids(keys: $keys, registro: $registros);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error validar campos', data: $valida);
        }

        $registros['codigo'] = $this->get_codigo_aleatorio();
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error generar codigo', data: $registros);
        }

        $registros['codigo'] .= " - ".$registros['rfc'];
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

    /**
     * Función para obtener cotizaciones filtradas por el ID de un proveedor.
     * Si se especifica una etapa, se filtran las cotizaciones por etapa.
     *
     * @param int $gt_proveedor_id El ID del proveedor.
     * @param String $etapa etapa para filtrar los registros(ALTA, AUTORIZADO).
     *
     * @return array|stdClass Retorna un array de cotizaciones o un objeto stdClass vacío.
     * Si se produce un error durante la filtración, se devuelve un objeto de error.
     */
    public function obtener_cotizaciones(int $gt_proveedor_id, String $etapa = ""): array|stdClass
    {
        if ($etapa != "") {
            $filtro = array('gt_cotizacion.etapa' => $etapa);
        }

        $filtro['gt_cotizacion.gt_proveedor_id'] = $gt_proveedor_id;
        $cotizaciones = (new gt_cotizacion($this->link))->filtro_and(filtro: $filtro);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error filtrar cotizacion', data: $cotizaciones);
        }

        return $cotizaciones;
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
     * Función para obtener el total de las cotizaciones de un proveedor.
     *
     * @param int $gt_proveedor_id El ID del proveedor.
     *
     * @return array|stdClass Retorna un array con el total de las cotizaciones en alta y autorizadas.
     * Si se produce un error durante la obtención de los datos, se devuelve un objeto de error.
     */
    public function total_saldos_cotizacion(int $gt_proveedor_id): array|stdClass
    {
        $cotizaciones_alta = $this->obtener_cotizaciones(gt_proveedor_id: $gt_proveedor_id,etapa: "ALTA");
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al obtener cotizaciones en alta', data: $cotizaciones_alta);
        }

        $cotizaciones_autorizado = $this->obtener_cotizaciones(gt_proveedor_id: $gt_proveedor_id,etapa: "AUTORIZADO");
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al obtener cotizaciones autorizadas', data: $cotizaciones_autorizado);
        }

        $total_alta = $this->total_saldos_cotizacion_proceso(cotizaciones: $cotizaciones_alta);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al calcular el total de saldos de cotizacion en alta',
                data: $total_alta);
        }

        $total_autorizado = $this->total_saldos_cotizacion_proceso(cotizaciones: $cotizaciones_autorizado);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al calcular el total de saldos de cotizacion autorizadas',
                data: $total_autorizado);
        }

        $total_cotizacion = [
            "total_alta" => $total_alta,
            "total_autorizado" => $total_autorizado,
            "total" => $total_alta + $total_autorizado,
        ];

        return $total_cotizacion;
    }

    /**
    * Función para calcular el total de saldos de cotizaciones en un proceso.
     *
     * @param stdClass $cotizaciones El objeto de cotizaciones.
     *
     * @return array|stdClass|float Retorna el total de saldos de cotizaciones en un proceso.
     * Si se produce un error durante la obtención o suma de los datos, se devuelve un objeto de error.
    */
    private function total_saldos_cotizacion_proceso(stdClass $cotizaciones): array|stdClass|float
    {
        $aplanados = $this->aplanar($cotizaciones->registros, "gt_cotizacion_id");
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al aplanar datos por gt_cotizacion_id', data: $aplanados);
        }

        $total = 0.0;

        foreach ($aplanados as $elemento) {
            $suma = $this->suma_productos_cotizacion(gt_cotizacion_id: $elemento);
            if (errores::$error) {
                return $this->error->error(mensaje: 'Error al calcular totales de productos de la cotizacion',
                    data: $suma);
            }

            $total += $suma;
        }

        return round(num: $total, precision: 2);
    }

    /**
     * Función para calcular la suma total de los productos asociados a una cotizacion.
     *
     * @param int $gt_cotizacion_id El ID de la cotizacion.
     *
     * @return array|stdClass|float Retorna la suma total de los productos de la cotizacion.
     * Si se produce un error durante la obtención o suma de los datos, se devuelve un objeto de error.
     */
    public function suma_productos_cotizacion(int $gt_cotizacion_id): array|stdClass|float
    {
        $campos = array("gt_cotizacion_producto_total");
        $filtro = ['gt_cotizacion_producto.gt_cotizacion_id' => $gt_cotizacion_id];
        $datos = (new gt_cotizacion_producto($this->link))->filtro_and(
            columnas: $campos,
            filtro: $filtro
        );
        if (errores::$error) {
            return $this->error->error('Error al obtener los datos de la cotizacion', $datos);
        }

        $suma = $this->sumar(datos: $datos->registros, columna: "gt_cotizacion_producto_total");
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
     * @return array|float Retorna la suma de los valores de la columna especificada.
     */
    function sumar(array $datos, string $columna): array|float
    {
        $valores = $this->aplanar(datos: $datos, columna: $columna);
        if (errores::$error) {
            return $this->error->error(mensaje: 'Error al aplanar datos por $columna', data: $valores);
        }

        return round(num: array_sum($valores), precision: 2);
    }

}