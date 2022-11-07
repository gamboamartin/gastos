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
use html\cat_sat_regimen_fiscal_html;
use html\dp_calle_pertenece_html;
use html\gt_proveedor_html;
use html\gt_tipo_proveedor_html;
use models\gt_proveedor;

use PDO;
use stdClass;

class controlador_gt_proveedor extends system {

    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(), stdClass $paths_conf = new stdClass()){
        $modelo = new gt_proveedor(link: $link);

        $html_ = new gt_proveedor_html(html: $html);

        $obj_link = new links_menu(link: $link, registro_id:$this->registro_id);
        $this->rows_lista[] = 'gt_tipo_proveedor_id';
        $this->rows_lista[] = 'dp_calle_pertenece_id';
        $this->rows_lista[] = 'cat_sat_regimen_fiscal_id';
        $this->rows_lista[] = 'rfc';
        $this->rows_lista[] = 'razon_social';
        $this->rows_lista[] = 'exterior';
        $this->rows_lista[] = 'interior';
        $this->rows_lista[] = 'telefono_1';
        $this->rows_lista[] = 'telefono_2';
        $this->rows_lista[] = 'telefono_3';
        $this->rows_lista[] = 'contacto_1';
        $this->rows_lista[] = 'contacto_2';
        $this->rows_lista[] = 'contacto_3';
        $this->rows_lista[] = 'pagina_web';
        parent::__construct(html:$html_, link: $link,modelo:  $modelo, obj_link: $obj_link, paths_conf: $paths_conf);

        $this->titulo_lista = 'Proveedor';

    }


    public function proveedor_datos_fiscales(bool $header, bool $ws = false, string $breadcrumbs = '', bool $aplica_form = true,
                                       bool $muestra_btn = true): array|string
    {
        $r_modifica =  parent::modifica($header, $ws, $breadcrumbs, $aplica_form, $muestra_btn); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al generar template',data:  $r_modifica, header: $header,ws:$ws);
        }

        $select = (new cat_sat_regimen_fiscal_html(html: $this->html_base))->select_cat_sat_regimen_fiscal_id(cols:12,con_registros: true,
            id_selected: $this->row_upd->cat_sat_regimen_fiscal_id, link: $this->link);
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al generar select', data: $select);
            print_r($error);
            die('Error');
        }
        $this->inputs->select = new stdClass();
        $this->inputs->select->cat_sat_regimen_fiscal_id = $select;

        $select = (new dp_calle_pertenece_html(html: $this->html_base))->select_dp_calle_pertenece_id(cols:12,con_registros:true,
            id_selected:$this->row_upd->dp_calle_pertenece_id, link: $this->link, required: true);
        if(errores::$error){
            $error = $this->errores->error(mensaje: 'Error al generar select',data:  $select);
            print_r($error);
            die('Error');
        }

        $this->inputs->select->dp_calle_pertenece_id = $select;

        $select = (new gt_tipo_proveedor_html(html: $this->html_base))->select_gt_tipo_proveedor_id(cols:12,con_registros: true,
            id_selected: $this->row_upd->gt_tipo_proveedor_id, link: $this->link,required: true);
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al generar select', data: $select);
            print_r($error);
            die('Error');
        }
        $this->inputs->select->gt_tipo_proveedor_id = $select;
        return $r_modifica;
    }



    public function modifica_datos_fiscales(bool $header, bool $ws = false, string $breadcrumbs = '',
                                            bool $aplica_form = false, bool $muestra_btn = true): array|string
    {

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

        return array();
    }

    public function alta(bool $header, bool $ws = false): array|string
    {
        $r_alta = parent::alta(header: false, ws: false); // TODO: Change the autogenerated stub
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al generar template', data: $r_alta, header: $header, ws: $ws);
        }

        $select = (new dp_calle_pertenece_html(html: $this->html_base))->select_dp_calle_pertenece_id(cols:12,con_registros: true,
            id_selected: -1, link: $this->link, required: true);
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al generar select', data: $select);
            print_r($error);
            die('Error');
        }

        $this->inputs->select = new stdClass();
        $this->inputs->select->dp_calle_pertenece_id = $select;

        $select = (new cat_sat_regimen_fiscal_html(html: $this->html_base))->select_cat_sat_regimen_fiscal_id(cols:12,con_registros: true,
            id_selected: -1, link: $this->link, required: true);
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al generar select', data: $select);
            print_r($error);
            die('Error');
        }

        $this->inputs->select->cat_sat_regimen_fiscal_id = $select;

        $select = (new gt_tipo_proveedor_html(html: $this->html_base))->select_gt_tipo_proveedor_id(
            cols:12,con_registros: true, id_selected: -1, link: $this->link,required: true);
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al generar select', data: $select);
            print_r($error);
            die('Error');
        }

        $this->inputs->select->gt_tipo_proveedor_id = $select;


        return $r_alta;

    }

    public function modifica(bool $header, bool $ws = false, string $breadcrumbs = '', bool $aplica_form = true,
                             bool $muestra_btn = true): array|string
    {
        $r_modifica =  parent::modifica($header, $ws, $breadcrumbs, $aplica_form, $muestra_btn); // TODO: Change the autogenerated stub
        if(errores::$error){
            return $this->retorno_error(mensaje: 'Error al generar template',data:  $r_modifica, header: $header,ws:$ws);
        }

        $select = (new dp_calle_pertenece_html(html: $this->html_base))->select_dp_calle_pertenece_id(cols:12,con_registros:true,
            id_selected:$this->row_upd->dp_calle_pertenece_id, link: $this->link, required: true);
        if(errores::$error){
            $error = $this->errores->error(mensaje: 'Error al generar select',data:  $select);
            print_r($error);
            die('Error');
        }

        $this->inputs->select = new stdClass();
        $this->inputs->select->dp_calle_pertenece_id = $select;

        $select = (new gt_tipo_proveedor_html(html: $this->html_base))->select_gt_tipo_proveedor_id(cols:12,con_registros:true,
            id_selected:$this->row_upd->gt_tipo_proveedor_id, link: $this->link,required: true);
        if(errores::$error){
            $error = $this->errores->error(mensaje: 'Error al generar select',data:  $select);
            print_r($error);
            die('Error');
        }


        $this->inputs->select->gt_tipo_proveedor_id = $select;


        $select = (new cat_sat_regimen_fiscal_html(html: $this->html_base))->select_cat_sat_regimen_fiscal_id(cols:12,con_registros:true,
            id_selected:$this->row_upd->cat_sat_regimen_fiscal_id, link: $this->link, required: true);
        if(errores::$error){
            $error = $this->errores->error(mensaje: 'Error al generar select',data:  $select);
            print_r($error);
            die('Error');
        }


        $this->inputs->select->cat_sat_regimen_fiscal_id = $select;



        return $r_modifica;
    }


    public function modifica_datos_generales(){


        /*$_POST['dp_calle_pertenece_id'] = 1;
        $_POST['cat_sat_regimen_fiscal_id'] = 1;
        $_POST['rfc'] = 1;
        $_POST['exterior'] = 1;
        $_POST['interior'] = 1;
        $_POST[ 'telefono_1'] = 1;
        $_POST[ 'telefono_2'] = 1;
        $_POST[ 'telefono_3'] = 1;
        $_POST[ 'contacto_1'] = 1;
        $_POST[ 'contacto_2'] = 1;
        $_POST[ 'contacto_3'] = 1;*/

        $this->modifica_bd(header: false, ws: false);

    }
}