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
use gamboamartin\gastos\models\gt_solicitantes;
use gamboamartin\system\links_menu;
use gamboamartin\system\system;
use gamboamartin\template\html;
use html\gt_solicitante_html;
use html\gt_solicitantes_html;
use html\gt_solicitud_html;

use PDO;
use stdClass;

class controlador_gt_solicitantes extends system {

    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(), stdClass $paths_conf = new stdClass()){
        $modelo = new gt_solicitantes(link: $link);

        $html = new gt_solicitantes_html(html: $html);
        $obj_link = new links_menu(link: $link, registro_id:$this->registro_id);
        $this->rows_lista[] = 'gt_solicitud_id';
        $this->rows_lista[] = 'gt_solicitante_id';

        parent::__construct(html:$html, link: $link,modelo:  $modelo, obj_link: $obj_link, paths_conf: $paths_conf);

        $this->titulo_lista = 'Solicitantes';

    }
    public function alta(bool $header, bool $ws = false): array|string
    {
        $r_alta = parent::alta(header: false, ws: false); // TODO: Change the autogenerated stub
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al generar template', data: $r_alta, header: $header, ws: $ws);
        }

        $select = (new gt_solicitante_html(html: $this->html_base))->select_gt_solicitante_id(cols:12,con_registros: true,
            id_selected: -1, link: $this->link,required: true);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al generar select', data: $select, header: $header, ws: $ws);
        }

        $this->inputs->select = new stdClass();
        $this->inputs->select->gt_solicitante_id = $select;

        $select = (new gt_solicitud_html(html: $this->html_base))->select_gt_solicitud_id(cols:12,con_registros: true,
            id_selected: -1, link: $this->link,required: true);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al generar select', data: $select, header: $header, ws: $ws);
        }

        $this->inputs->select->gt_solicitud_id = $select;

        return $r_alta;

    }

    public function modifica(bool $header, bool $ws = false): array|stdClass
    {
        $r_modifica =  parent::modifica($header, $ws); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al generar template',data:  $r_modifica, header: $header,ws:$ws);
        }

        $select = (new gt_solicitante_html(html: $this->html_base))->select_gt_solicitante_id(cols:12,con_registros: true,
            id_selected:$this->row_upd->gt_solicitante_id, link: $this->link,required: true);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al generar select', data: $select, header: $header, ws: $ws);
        }

        $this->inputs->select = new stdClass();
        $this->inputs->select->gt_solicitante_id = $select;

        $select = (new gt_solicitud_html(html: $this->html_base))->select_gt_solicitud_id(cols:12,con_registros: true,
            id_selected:$this->row_upd->gt_solicitud_id, link: $this->link,required: true);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al generar select', data: $select, header: $header, ws: $ws);
        }

        $this->inputs->select->gt_solicitud_id = $select;
        return $r_modifica;
    }

    public function alta_bd(bool $header, bool $ws = false): array|stdClass
    {

        $r_alta_bd = parent::alta_bd(false, false); // TODO: Change the autogenerated stub

        $url_components = parse_url($_SERVER['HTTP_REFERER']);
        parse_str($url_components['query'], $params);

        $url = './index.php?seccion='. $params['seccion'] .'&accion='. $params['accion'] .'&registro_id='. $params['registro_id'] .'&session_id='. $params['session_id'];

        if($params['seccion'] != 'gt_solicitantes'){
            //var_dump($this); exit;
            header('location:'.$url);
        }

        return $r_alta_bd;
    }
}
