<?php
namespace gamboamartin\gastos\models;
use base\orm\_modelo_parent;
use PDO;

class gt_autorizantes extends _modelo_parent{
    public function __construct(PDO $link){
        $tabla = 'gt_autorizantes';
        $columnas = array($tabla=>false, 'gt_solicitud' => $tabla, 'gt_autorizante' => $tabla, "em_empleado" => 'gt_autorizante');
        $campos_obligatorios = array();

        $no_duplicados = array();


        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas,no_duplicados: $no_duplicados);

        $this->NAMESPACE = __NAMESPACE__;
    }

}