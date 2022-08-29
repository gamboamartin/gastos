<?php
namespace html;

use gamboamartin\errores\errores;
use gamboamartin\system\html_controler;
use models\gt_tipo_solicitud;
use PDO;
use stdClass;

class gt_tipo_solicitud_html extends html_controler {
    public function select_gt_tipo_solicitud_id(int $cols, bool $con_registros,int $id_selected, PDO $link): array|string
    {
        $modelo = new gt_tipo_solicitud($link);

        $select = $this->select_catalogo(cols:$cols, con_registros: $con_registros,id_selected:$id_selected, modelo: $modelo);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }
}
