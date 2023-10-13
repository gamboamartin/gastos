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

}