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
use gamboamartin\system\_ctl_parent_sin_codigo;
use gamboamartin\system\links_menu;
use gamboamartin\template\html;
use html\gt_tipo_solicitud_html;
use models\gt_tipo_solicitud;
use PDO;
use stdClass;

class controlador_gt_tipo_solicitud extends _ctl_parent_sin_codigo {

    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(), stdClass $paths_conf = new stdClass()){
        $modelo = new gt_tipo_solicitud(link: $link);

        $html = new gt_tipo_solicitud_html(html: $html);
        $obj_link = new links_menu(link: $link, registro_id:$this->registro_id);


        $datatables = new stdClass();
        $datatables->columns = array();
        $datatables->columns['gt_tipo_solicitud_id']['titulo'] = 'Id';
        $datatables->columns['gt_tipo_solicitud_descripcion']['titulo'] = 'Tipo de Solicitud';


        $datatables->filtro = array();
        $datatables->filtro[] = 'gt_tipo_solicitud.id';
        $datatables->filtro[] = 'gt_tipo_solicitud.descripcion';

        parent::__construct(html: $html, link: $link, modelo: $modelo, obj_link: $obj_link, datatables: $datatables,
            paths_conf: $paths_conf);

        $this->titulo_lista = 'Tipo Solicitud';

    }


    /**
     * Maqueta elementos de inputs para views
     * @param array $keys_selects Keys a integrar
     * @return array
     * @version 0.161.4
     */
    protected function key_selects_txt(array $keys_selects): array
    {
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6,key: 'codigo',
            keys_selects:$keys_selects, place_holder: 'Cod');
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6,key: 'descripcion',
            keys_selects:$keys_selects, place_holder: 'Tipo de Solicitud');
        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al maquetar key_selects',data:  $keys_selects);
        }

        return $keys_selects;
    }
}
