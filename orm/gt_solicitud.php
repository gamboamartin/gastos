<?php
namespace models;
use base\orm\modelo;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class gt_solicitud extends modelo{
    public function __construct(PDO $link){
        $tabla = __CLASS__;
        $columnas = array($tabla=>false);
        $campos_obligatorios = array();

        $no_duplicados = array();


        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas,no_duplicados: $no_duplicados);
    }

    public function alta_bd(): array|stdClass
    {
        if(!isset($this->registro['codigo']))
            $this->registro['codigo'] = $this->registro['gt_centro_costo_id'].'.'.$this->registro['gt_tipo_solicitud_id'].'.'.rand();
        if(!isset($this->registro['descripcion_select']))
            $this->registro['descripcion_select'] = strtoupper($this->registro['descripcion']). ' ' .$this->registro['gt_centro_costo_id'].' '.$this->registro['gt_tipo_solicitud_id'];
        if(!isset($this->registro['alias']))
            $this->registro['alias'] = $this->registro['descripcion_select'];
        if(!isset($this->registro['codigo_bis']))
            $this->registro['codigo_bis'] = $this->registro['codigo'];

        $r_alta_bd = parent::alta_bd();
        if(errores::$error){
            return $this->error->error('Error al dar de alta registro',$r_alta_bd);
        }

        return $r_alta_bd;
    }

}