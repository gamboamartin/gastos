<?php
namespace gamboamartin\gastos\models;
use base\orm\modelo;
use PDO;


class gt_solicitante extends modelo{
    public function __construct(PDO $link){
        $tabla = 'gt_solicitante';
        $columnas = array($tabla=>false);
        $campos_obligatorios = array();

        $no_duplicados = array();


        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas,no_duplicados: $no_duplicados);

        $this->NAMESPACE = __NAMESPACE__;
    }
}