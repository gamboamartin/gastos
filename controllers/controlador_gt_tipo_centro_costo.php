<?php
/**
 * @author Martin Gamboa Vazquez
 * @version 1.0.0
 * @created 2022-05-14
 * @final En proceso
 *
 */
namespace gamboamartin\gastos\controllers;

use gamboamartin\errores\errores;
use gamboamartin\gastos\models\gt_tipo_centro_costo;
use gamboamartin\system\_ctl_parent_sin_codigo;
use gamboamartin\system\links_menu;
use gamboamartin\template\html;
use html\gt_tipo_centro_costo_html;
use PDO;
use stdClass;

class controlador_gt_tipo_centro_costo extends _ctl_parent_sin_codigo {

    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(), stdClass $paths_conf = new stdClass()){
        $modelo = new gt_tipo_centro_costo(link: $link);

        $html = new gt_tipo_centro_costo_html(html: $html);
        $obj_link = new links_menu(link: $link, registro_id:$this->registro_id);


        $datatables = new stdClass();
        $datatables->columns = array();
        $datatables->columns['gt_tipo_centro_costo_id']['titulo'] = 'Id';
        $datatables->columns['gt_tipo_centro_costo_descripcion']['titulo'] = 'Tipo de Centro Costo';


        $datatables->filtro = array();
        $datatables->filtro[] = 'gt_tipo_centro_costo.id';
        $datatables->filtro[] = 'gt_tipo_centro_costo.descripcion';

        parent::__construct(html: $html, link: $link, modelo: $modelo, obj_link: $obj_link, datatables: $datatables,
            paths_conf: $paths_conf);

        $this->titulo_lista = 'Tipo Centro Costo';

    }

    protected function key_selects_txt(array $keys_selects): array
    {
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6,key: 'codigo',
            keys_selects:$keys_selects, place_holder: 'Cod');
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6,key: 'descripcion',
            keys_selects:$keys_selects, place_holder: 'Tipo de Centro Costo');
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects);
        }

        return $keys_selects;
    }
}
