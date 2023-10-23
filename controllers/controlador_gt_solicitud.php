<?php
/**
 * @author Martin Gamboa Vazquez
 * @version 1.0.0
 * @created 2022-05-14
 * @final En proceso
 *
 */
namespace gamboamartin\gastos\controllers;

use base\controller\controler;
use gamboamartin\errores\errores;
use gamboamartin\gastos\models\gt_solicitud;
use gamboamartin\system\_ctl_parent_sin_codigo;
use gamboamartin\system\links_menu;
use gamboamartin\template\html;
use html\gt_autorizante_html;
use html\gt_solicitante_html;
use html\gt_solicitud_html;
use html\gt_centro_costo_html;
use html\gt_tipo_solicitud_html;
use PDO;
use stdClass;

class controlador_gt_solicitud extends _ctl_parent_sin_codigo {

    public string $link_partidas = '';

    public function __construct(PDO      $link, html $html = new \gamboamartin\template_1\html(),
                                stdClass $paths_conf = new stdClass())
    {
        $modelo = new gt_solicitud(link: $link);
        $html_ = new gt_solicitud_html(html: $html);
        $obj_link = new links_menu(link: $link, registro_id: $this->registro_id);

        $datatables = $this->init_datatable();
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al inicializar datatable', data: $datatables);
            print_r($error);
            die('Error');
        }

        parent::__construct(html: $html_, link: $link, modelo: $modelo, obj_link: $obj_link, datatables: $datatables,
            paths_conf: $paths_conf);

        $configuraciones = $this->init_configuraciones();
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al inicializar configuraciones', data: $configuraciones);
            print_r($error);
            die('Error');
        }

        $init_links = $this->init_links();
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al inicializar links', data: $init_links);
            print_r($error);
            die('Error');
        }

        $this->lista_get_data = true;
    }

    public function alta(bool $header, bool $ws = false): array|string
    {
        $r_alta = $this->init_alta();
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al inicializar alta', data: $r_alta, header: $header, ws: $ws);
        }

        $keys_selects = $this->init_selects_inputs();
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al inicializar selects', data: $keys_selects, header: $header,
                ws: $ws);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 12, key: 'descripcion',
            keys_selects: $keys_selects, place_holder: 'Descripción');

        $inputs = $this->inputs(keys_selects: $keys_selects);
        if (errores::$error) {
            return $this->retorno_error(
                mensaje: 'Error al obtener inputs', data: $inputs, header: $header, ws: $ws);
        }

        return $r_alta;
    }

    protected function campos_view(array $inputs = array()): array
    {
        $keys = new stdClass();
        $keys->inputs = array('codigo', 'descripcion');
        $keys->telefonos = array();
        $keys->fechas = array();
        $keys->selects = array();

        $init_data = array();
        $init_data['gt_centro_costo'] = "gamboamartin\\gastos";
        $init_data['gt_tipo_solicitud'] = "gamboamartin\\gastos";
        $init_data['gt_solicitante'] = "gamboamartin\\gastos";
        $init_data['gt_autorizante'] = "gamboamartin\\gastos";
        $init_data['em_empleado'] = "gamboamartin\\empleado";

        $campos_view = $this->campos_view_base(init_data: $init_data, keys: $keys);
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al inicializar campo view', data: $campos_view);
        }

        return $campos_view;
    }

    private function init_configuraciones(): controler
    {
        $this->seccion_titulo = 'Solicitud';
        $this->titulo_lista = 'Registro de Solicitud';

        $this->lista_get_data = true;

        return $this;
    }

    protected function init_datatable(): stdClass
    {
        $columns["gt_solicitud_id"]["titulo"] = "Id";
        $columns["gt_tipo_solicitud_descripcion"]["titulo"] = "Tipo";
        $columns["gt_centro_costo_descripcion"]["titulo"] = "Centro Costo";
        $columns["gt_solicitud_descripcion"]["titulo"] = "Descripción";

        $filtro = array("gt_solicitud.id","gt_tipo_solicitud.descripcion","gt_centro_costo.descripcion",
            "gt_solicitud.descripcion");

        $datatables = new stdClass();
        $datatables->columns = $columns;
        $datatables->filtro = $filtro;

        return $datatables;
    }

    protected function init_links(): array|string
    {
        $links = $this->obj_link->genera_links(controler: $this);
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al generar links', data: $links);
            print_r($error);
            exit;
        }

        $link = $this->obj_link->get_link(seccion: "gt_solicitud", accion: "partidas");
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al recuperar link partidas', data: $link);
            print_r($error);
            exit;
        }
        $this->link_partidas = $link;

        return $link;
    }

    private function init_selects(array $keys_selects, string $key, string $label, int $id_selected = -1, int $cols = 6,
                                  bool  $con_registros = true, array $filtro = array()): array
    {
        $keys_selects = $this->key_select(cols: $cols, con_registros: $con_registros, filtro: $filtro, key: $key,
            keys_selects: $keys_selects, id_selected: $id_selected, label: $label);
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        return $keys_selects;
    }

    public function init_selects_inputs(): array
    {
        $keys_selects = $this->init_selects(keys_selects: array(), key: "gt_centro_costo_id", label: "Centro Costo", cols: 12);
        $keys_selects = $this->init_selects(keys_selects: $keys_selects, key: "em_empleado_id", label: "Empleado", cols: 12);
        $keys_selects = $this->init_selects(keys_selects: $keys_selects, key: "gt_solicitante_id", label: "Solicitante", cols: 12);
        $keys_selects = $this->init_selects(keys_selects: $keys_selects, key: "gt_autorizante_id", label: "Autorizante", cols: 12);
        return $this->init_selects(keys_selects: $keys_selects, key: "gt_tipo_solicitud_id", label: "Tipo Solicitud", cols: 12);
    }

    protected function key_selects_txt(array $keys_selects): array
    {
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 4, key: 'codigo',
            keys_selects: $keys_selects, place_holder: 'Código');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        return $keys_selects;
    }

    public function modifica(bool $header, bool $ws = false, array $keys_selects = array()): array|stdClass
    {
        $r_modifica = $this->init_modifica();
        if (errores::$error) {
            return $this->retorno_error(
                mensaje: 'Error al generar salida de template', data: $r_modifica, header: $header, ws: $ws);
        }



        $keys_selects = $this->init_selects_inputs();
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al inicializar selects', data: $keys_selects, header: $header,
                ws: $ws);
        }

        $keys_selects['gt_centro_costo_id']->id_selected = $this->registro['gt_centro_costo_id'];
        $keys_selects['gt_tipo_solicitud_id']->id_selected = $this->registro['gt_tipo_solicitud_id'];

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 12, key: 'descripcion',
            keys_selects: $keys_selects, place_holder: 'Descripción');
        $keys_selects['descripcion']->disabled = true;
        $keys_selects['gt_centro_costo_id']->disabled = true;
        $keys_selects['gt_tipo_solicitud_id']->disabled = true;

        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        $base = $this->base_upd(keys_selects: $keys_selects, params: array(), params_ajustados: array());
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al integrar base', data: $base, header: $header, ws: $ws);
        }

        return $r_modifica;
    }


    public function partidas(bool $header, bool $ws = false): array|stdClass
    {
        $r_modifica = $this->init_modifica();
        if (errores::$error) {
            return $this->retorno_error(
                mensaje: 'Error al generar salida de template', data: $r_modifica, header: $header, ws: $ws);
        }

        $keys_selects = $this->init_selects_inputs();
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al inicializar selects', data: $keys_selects, header: $header,
                ws: $ws);
        }

        $keys_selects['gt_centro_costo_id']->id_selected = $this->registro['gt_centro_costo_id'];
        $keys_selects['gt_tipo_solicitud_id']->id_selected = $this->registro['gt_tipo_solicitud_id'];

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 12, key: 'descripcion',
            keys_selects: $keys_selects, place_holder: 'Descripción');
        $keys_selects['descripcion']->disabled = true;
        $keys_selects['gt_centro_costo_id']->disabled = true;
        $keys_selects['gt_tipo_solicitud_id']->disabled = true;

        $base = $this->base_upd(keys_selects: $keys_selects, params: array(), params_ajustados: array());
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al integrar base', data: $base, header: $header, ws: $ws);
        }

        return $r_modifica;
    }



    public function asignar_solicitante(bool $header, bool $ws = false): array|string
    {

        $r_modifica =  parent::modifica($header, $ws); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al generar template',data:  $r_modifica, header: $header,ws:$ws);
        }
        if($this->registro_id<=0){
            return $this->retorno_error(mensaje: 'Error registro_id debe ser mayor a 0', data: $this->registro_id,
                header:  $header, ws: $ws);
        }

        if(!isset($this->row_upd)){
            $this->row_upd = new stdClass();
        }
        if(!isset($this->row_upd->status)){
            $this->row_upd->status = '';
        }

        $this->row_upd = (object)($this->modelo->registro(registro_id: $this->registro_id));

        $select = (new gt_solicitante_html(html: $this->html_base))->select_gt_solicitante_id(cols:12,con_registros: true,
            id_selected: -1, link: $this->link,required: true);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al generar select', data: $select, header: $header, ws: $ws);
        }

        $this->inputs->select = new stdClass();
        $this->inputs->select->gt_solicitante_id = $select;


        $select = (new gt_solicitud_html(html: $this->html_base))->select_gt_solicitud_id(cols:12,con_registros: true,
            id_selected: $this->row_upd->gt_solicitud_id , link: $this->link,required: true, disabled: true);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al generar select', data: $select, header: $header, ws: $ws);
        }

        $this->inputs->select->gt_solicitud_id = $select;




        return array();
    }

    public function asignar_autorizante(bool $header, bool $ws = false): array|string
    {

        $r_modifica =  parent::modifica($header, $ws); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al generar template',data:  $r_modifica, header: $header,ws:$ws);
        }
        if($this->registro_id<=0){
            return $this->retorno_error(mensaje: 'Error registro_id debe ser mayor a 0', data: $this->registro_id,
                header:  $header, ws: $ws);
        }

        if(!isset($this->row_upd)){
            $this->row_upd = new stdClass();
        }
        if(!isset($this->row_upd->status)){
            $this->row_upd->status = '';
        }

        $this->row_upd = (object)($this->modelo->registro(registro_id: $this->registro_id));

        $select = (new gt_autorizante_html(html: $this->html_base))->select_gt_autorizante_id(cols:12,con_registros: true,
            id_selected: -1, link: $this->link,required: true);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al generar select', data: $select, header: $header, ws: $ws);
        }

        $this->inputs->select = new stdClass();
        $this->inputs->select->gt_autorizante_id = $select;


        $select = (new gt_solicitud_html(html: $this->html_base))->select_gt_solicitud_id(cols: 12, con_registros: true,
            id_selected: $this->row_upd->gt_solicitud_id, link: $this->link, disabled: true, required: true);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al generar select', data: $select, header: $header, ws: $ws);
        }

        $this->inputs->select->gt_solicitud_id = $select;




        return array();
    }

    protected function inputs_children(stdClass $registro): array|stdClass{

        $gt_solicitud_id = (new gt_solicitud_html(html: $this->html_base))->select_gt_solicitud_id(
            cols:12,con_registros: true,id_selected:  $registro->gt_solicitud_id,link:  $this->link, disabled: true);

        if(errores::$error){
            return $this->errores->error(mensaje: 'Error al obtener gt_tipo_solicitud_id',data:  $gt_solicitud_id);
        }



        $this->inputs = new stdClass();
        $this->inputs->select = new stdClass();
        $this->inputs->select->gt_solicitud_id = $gt_solicitud_id;


        return $this->inputs;
    }

    public function solicitantes(bool $header = true, bool $ws = false): array|stdClass|string
    {

        $data_view = new stdClass();
        $data_view->names = array('Id','Solicitud', 'Solicitante','Acciones');
        $data_view->keys_data = array('gt_solicitantes_id','gt_solicitud_codigo','gt_solicitante_codigo');
        $data_view->key_actions = 'acciones';
        $data_view->namespace_model = 'gamboamartin\\gastos\\models';
        $data_view->name_model_children = 'gt_solicitantes';


        $contenido_table = $this->contenido_children(data_view: $data_view, next_accion: __FUNCTION__);
        if(errores::$error){
            return $this->retorno_error(
                mensaje: 'Error al obtener tbody',data:  $contenido_table, header: $header,ws:  $ws);
        }


        return $contenido_table;

    }

    public function autorizantes(bool $header = true, bool $ws = false): array|stdClass|string
    {

        $data_view = new stdClass();
        $data_view->names = array('Id','Solicitud', 'Autorizante','Acciones');
        $data_view->keys_data = array('gt_autorizantes_id','gt_solicitud_codigo','gt_autorizante_codigo');
        $data_view->key_actions = 'acciones';
        $data_view->namespace_model = 'gamboamartin\\gastos\\models';
        $data_view->name_model_children = 'gt_autorizantes';


        $contenido_table = $this->contenido_children(data_view: $data_view, next_accion: __FUNCTION__);
        if(errores::$error){
            return $this->retorno_error(
                mensaje: 'Error al obtener tbody',data:  $contenido_table, header: $header,ws:  $ws);
        }


        return $contenido_table;

    }


}
