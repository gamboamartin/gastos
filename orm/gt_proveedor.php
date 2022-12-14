<?php
namespace gamboamartin\gastos\models;
use base\orm\modelo;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class gt_proveedor extends modelo{
    public function __construct(PDO $link){
        $tabla = 'gt_proveedor';
        $columnas = array($tabla=>false);
        $campos_obligatorios = array('gt_tipo_proveedor_id', 'dp_calle_pertenece_id', 'cat_sat_regimen_fiscal_id',
            'rfc', 'exterior', 'telefono_1', 'contacto_1', 'pagina_web');

        $no_duplicados = array();

        $tipo_campos['telefono_1'] = 'telefono_mx';
        $tipo_campos['telefono_2'] = 'telefono_mx';
        $tipo_campos['telefono_3'] = 'telefono_mx';
        $tipo_campos['pagina_web'] = 'url';

        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas,no_duplicados: $no_duplicados, tipo_campos: $tipo_campos);

        $this->NAMESPACE = __NAMESPACE__;
    }

    public function alta_bd(): array|stdClass
    {
        if(!isset($this->registro['descripcion']))
            $this->registro['descripcion'] = $this->registro['razon_social'];
        if(!isset($this->registro['descripcion_select']))
            $this->registro['descripcion_select'] = $this->registro['codigo']. ' ' .$this->registro['razon_social'];
        if(!isset($this->registro['alias']))
            $this->registro['alias'] = strtoupper($this->registro['descripcion_select']);
        if(!isset($this->registro['codigo_bis']))
            $this->registro['codigo_bis'] = $this->registro['codigo']. ' ' .$this->registro['rfc'];

        $r_alta_bd = parent::alta_bd();
        if(errores::$error){
            return $this->error->error('Error al dar de alta registro',$r_alta_bd);
        }

        return $r_alta_bd;
    }

    public function modifica_bd(array $registro, int $id, bool $reactiva = false): array|stdClass
    {

        if(!isset($registro['descripcion']))
            $registro['descripcion'] = $registro['razon_social'];
        if(!isset($registro['descripcion_select']))
            $registro['descripcion_select'] = $this->registros[0]['gt_proveedor_codigo']. ' '.$registro['razon_social'];
        if(!isset($registro['alias']))
            $registro['alias'] = strtoupper($registro['descripcion_select']);
        if(!isset($registro['codigo_bis']))
            $registro['codigo_bis'] = $this->registros[0]['gt_proveedor_codigo']. ' '.$registro['rfc'];
        $r_modifica_bd = parent::modifica_bd($registro, $id, $reactiva); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->error->error('Error al modificar registro',$r_modifica_bd);
        }

        return $r_modifica_bd;
    }



}