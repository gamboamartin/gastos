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
use gamboamartin\gastos\models\gt_tipo_solicitud;
use gamboamartin\system\_ctl_parent_sin_codigo;
use gamboamartin\system\links_menu;
use gamboamartin\template\html;
use html\gt_tipo_solicitud_html;
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

    protected function inputs_children(stdClass $registro): array|stdClass{

        $gt_tipo_solicitud_id = (new gt_tipo_solicitud_html(html: $this->html_base))->select_gt_tipo_solicitud_id(
            cols:12,con_registros: true,id_selected:  $registro->gt_tipo_solicitud_id,link:  $this->link, disabled: true);

        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al obtener gt_tipo_solicitud_id',data:  $gt_tipo_solicitud_id);
        }



        $this->inputs = new stdClass();
        $this->inputs->select = new stdClass();
        $this->inputs->select->gt_tipo_solicitud_id = $gt_tipo_solicitud_id;


        return $this->inputs;
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

    public function solicitudes(bool $header = true, bool $ws = false): array|stdClass|string
    {

        $data_view = new stdClass();
        $data_view->names = array('Id','Solicitud', 'CC','Acciones');
        $data_view->keys_data = array('gt_solicitud_id','gt_solicitud_codigo','gt_centro_costo_descripcion');
        $data_view->key_actions = 'acciones';
        $data_view->namespace_model = 'gamboamartin\\gastos\\models';
        $data_view->name_model_children = 'gt_solicitud';


        $contenido_table = $this->contenido_children(data_view: $data_view, next_accion: __FUNCTION__);
        if(errores::$error){
            return $this->retorno_error(
                mensaje: 'Error al obtener tbody',data:  $contenido_table, header: $header,ws:  $ws);
        }


        return $contenido_table;

    }
}
