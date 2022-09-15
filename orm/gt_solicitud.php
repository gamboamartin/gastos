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
        $gt_solicitantes = new gt_solicitantes($this->link);

        $r_alta_bd = parent::alta_bd();
        if(errores::$error){
            return $this->error->error('Error al dar de alta registro',$r_alta_bd);
        }


        $gt_solicitantes->registro['gt_solicitud_id'] = $r_alta_bd->registro['gt_solicitud_id'];
        $gt_solicitantes->registro['gt_solicitante_id'] = $_POST['gt_solicitante_id'];

        $gt_solicitantes->alta_bd();

        return $r_alta_bd;
    }

}