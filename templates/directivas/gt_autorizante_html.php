<?php
namespace html;

use gamboamartin\errores\errores;
use gamboamartin\system\html_controler;
use gamboamartin\template\directivas;
use models\gt_autorizante;
use PDO;
use stdClass;


class gt_autorizante_html extends html_controler {
    /**
     * @param bool $disabled Si disabled el input que da inactivo
     * @param array $filtro Filtro para obtencion de datos via filtro and del modelo
     * @return array|string
     */

    public function select_gt_autorizante_id(int $cols, bool $con_registros, int|null $id_selected, PDO $link,
                                             bool $disabled = false, array $filtro = array(),
                                             bool $required = false ): array|string
    {
        $valida = (new directivas(html:$this->html_base))->valida_cols(cols:$cols);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al validar cols', data: $valida);
        }
        if(is_null($id_selected)){
            $id_selected = -1;
        }

        $modelo = new gt_autorizante($link);

        $select = $this->select_catalogo(cols:$cols,con_registros:$con_registros,id_selected:$id_selected, filtro: $filtro,
            modelo: $modelo,label: 'Autorizante', name: 'tg_autorizante_id', disabled:$disabled, required: $required);
        if(errores::$error){
            return $this->error->error(mensaje: 'Error al generar select', data: $select);
        }
        return $select;
    }
}
