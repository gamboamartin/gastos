<?php
namespace gamboamartin\gastos\models;

use base\orm\_modelo_parent_sin_codigo;
use PDO;


class gt_orden_compra_cotizacion extends _modelo_parent_sin_codigo {
    public function __construct(PDO $link){
        $tabla = 'gt_orden_compra_cotizacion';
        $columnas = array($tabla=>false, "gt_cotizacion" => $tabla, "gt_orden_compra" => $tabla);
        $campos_obligatorios = array();

        $no_duplicados = array();


        parent::__construct(link: $link,tabla:  $tabla, campos_obligatorios: $campos_obligatorios,
            columnas: $columnas,no_duplicados: $no_duplicados);

        $this->NAMESPACE = __NAMESPACE__;
    }
}