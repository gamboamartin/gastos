<?php
namespace models;
use base\orm\modelo;
use gamboamartin\errores\errores;
use PDO;
use stdClass;

class gt_autorizantes extends modelo{
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
        $gt_autorizante = new gt_autorizante($this->link);

        $r_gt_autorizante = $gt_autorizante->registro(registro_id: $this->registro['gt_autorizante_id']);

        $gt_solicitud = new gt_solicitud($this->link);

        $r_gt_solicitud = $gt_solicitud->registro(registro_id: $this->registro['gt_solicitud_id']);


        if(!isset($this->registro['descripcion']))
            $this->registro['descripcion'] = $r_gt_solicitud['gt_solicitud_codigo'];
        if(!isset($this->registro['descripcion_select']))
            $this->registro['descripcion_select'] = $r_gt_solicitud['gt_solicitud_codigo']. ' - '. $r_gt_autorizante['gt_autorizante_codigo'];
        if(!isset($this->registro['alias']))
            $this->registro['alias'] = strtoupper($this->registro['descripcion_select']);
        if(!isset($this->registro['codigo_bis']))
            $this->registro['codigo_bis'] = $r_gt_solicitud['gt_solicitud_codigo']. ' ' . $r_gt_autorizante['gt_autorizante_codigo'];
        if(!isset($this->registro['codigo']))
            $this->registro['codigo'] = $r_gt_solicitud['gt_solicitud_codigo']. ' ' . $r_gt_autorizante['gt_autorizante_codigo'];

        $r_alta_bd = parent::alta_bd();
        if(errores::$error){
            return $this->error->error('Error al dar de alta registro',$r_alta_bd);
        }

        return $r_alta_bd;
    }
}