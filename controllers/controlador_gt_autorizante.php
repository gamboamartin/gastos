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
use gamboamartin\system\links_menu;
use gamboamartin\system\system;
use gamboamartin\template\html;
use html\em_empleado_html;
use html\gt_autorizante_html;
use models\gt_autorizante;
use PDO;
use stdClass;

class controlador_gt_autorizante extends system {

    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(), stdClass $paths_conf = new stdClass()){
        $modelo = new gt_autorizante(link: $link);

        $html = new gt_autorizante_html(html: $html);
        $obj_link = new links_menu(link: $link, registro_id:$this->registro_id);
        $this->rows_lista[] = 'em_empleado_id';
        parent::__construct(html:$html, link: $link,modelo:  $modelo, obj_link: $obj_link, paths_conf: $paths_conf);

        $this->titulo_lista = 'Autorizante';

    }

    public function alta(bool $header, bool $ws = false): array|string
    {
        $r_alta = parent::alta(header: false, ws: false); // TODO: Change the autogenerated stub
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al generar template', data: $r_alta, header: $header, ws: $ws);
        }

        $select = (new em_empleado_html(html: $this->html_base))->select_em_empleado_id(cols:12,con_registros: true,
            id_selected: -1, link: $this->link);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al generar select', data: $select, header: $header, ws: $ws);
        }

        $this->inputs->select = new stdClass();
        $this->inputs->select->em_empleado_id = $select;

        return $r_alta;

    }

    public function modifica(bool $header, bool $ws = false, string $breadcrumbs = '', bool $aplica_form = true,
                             bool $muestra_btn = true): array|string
    {
        $r_modifica =  parent::modifica($header, $ws, $breadcrumbs, $aplica_form, $muestra_btn); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al generar template',data:  $r_modifica, header: $header,ws:$ws);
        }

        $select = (new em_empleado_html(html: $this->html_base))->select_em_empleado_id(cols:12,con_registros:true,
            id_selected:$this->row_upd->em_empleado_id, link: $this->link);
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al generar select', data: $select, header: $header, ws: $ws);
        }

        $this->inputs->select = new stdClass();
        $this->inputs->select->em_empleado_id = $select;
        return $r_modifica;
    }

}