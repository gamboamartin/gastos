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
use gamboamartin\gastos\models\gt_requisicion;
use gamboamartin\gastos\models\gt_requisicion_producto;
use gamboamartin\gastos\models\gt_solicitud;
use gamboamartin\gastos\models\gt_solicitud_etapa;
use gamboamartin\gastos\models\gt_solicitud_producto;
use gamboamartin\gastos\models\gt_solicitud_requisicion;
use gamboamartin\gastos\models\gt_tipo_requisicion;
use gamboamartin\proceso\models\pr_etapa_proceso;
use gamboamartin\system\_ctl_parent_sin_codigo;
use gamboamartin\system\actions;
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
    public string $link_autoriza_bd = '';

    public string $link_producto_bd = '';

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

    public function autoriza(bool $header, bool $ws = false): array|stdClass
    {
        $this->accion_titulo = 'Autoriza';

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

        $keys_selects['gt_solicitante_id']->cols = 8;
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 4, key: 'fecha',
            keys_selects: $keys_selects, place_holder: 'Fecha');
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 12, key: 'observaciones',
            keys_selects: $keys_selects, place_holder: 'Observaciones');

        $this->row_upd->fecha = date("Y-m-d");

        $base = $this->base_upd(keys_selects: $keys_selects, params: array(), params_ajustados: array());
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al integrar base', data: $base, header: $header, ws: $ws);
        }

        return $r_modifica;
    }

    public function autoriza_bd(bool $header, bool $ws = false): array|stdClass
    {
        $this->link->beginTransaction();

        $siguiente_view = (new actions())->init_alta_bd();
        if (errores::$error) {
            $this->link->rollBack();
            return $this->retorno_error(mensaje: 'Error al obtener siguiente view', data: $siguiente_view,
                header: $header, ws: $ws);
        }

        if (isset($_POST['btn_action_next'])) {
            unset($_POST['btn_action_next']);
        }

        $etapa = constantes::PR_ETAPA_AUTORIZADO->value;
        $filtro['pr_etapa.descripcion'] = $etapa;
        $etapa_proceso = (new pr_etapa_proceso($this->link))->filtro_and(filtro: $filtro);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al integrar base', data: $etapa_proceso, header: $header, ws: $ws);
        }

        if ($etapa_proceso->n_registros <= 0){
            return $this->retorno_error(mensaje: "Error no existe la relacion de etapa proceso: $etapa",
                data: $etapa_proceso, header: $header, ws: $ws);
        }

        $registro = $etapa_proceso->registros[0];

        $registros['gt_solicitud_id'] = $this->registro_id;
        $registros['pr_etapa_proceso_id'] = $registro['pr_etapa_proceso_id'];
        $registros['fecha'] = $_POST['fecha'];

        $alta = (new gt_solicitud_etapa($this->link))->alta_registro(registro: $registros);
        if (errores::$error) {
            $this->link->rollBack();
            return $this->retorno_error(mensaje: 'Error al dar de alta solicitud etapa', data: $alta,
                header: $header, ws: $ws);
        }

        $filtro = array();
        $tipo = constantes::GT_TIPO_DEFAULT->value;
        $filtro['gt_tipo_requisicion.descripcion'] = $tipo;
        $tipo_requisicion = (new gt_tipo_requisicion($this->link))->filtro_and(filtro: $filtro);
        if (errores::$error) {
            $this->link->rollBack();
            return $this->retorno_error(mensaje: 'Error al integrar base', data: $tipo_requisicion, header: $header, ws: $ws);
        }

        if ($tipo_requisicion->n_registros <= 0){
            return $this->retorno_error(mensaje: "Error no existe EL tipo de requisicion: $tipo",
                data: $etapa_proceso, header: $header, ws: $ws);
        }

        $registro = $tipo_requisicion->registros[0];

        $solicitud = (new gt_solicitud($this->link))->registro(registro_id: $this->registro_id);
        if (errores::$error) {
            $this->link->rollBack();
            return $this->retorno_error(mensaje: 'Error no se pudo obtener los datos de solicitud', data: $solicitud,
                header: $header, ws: $ws);
        }

        $registros = array();
        $registros['gt_solicitud_id'] = $this->registro_id;
        $registros['gt_centro_costo_id'] = $solicitud['gt_centro_costo_id'];
        $registros['gt_tipo_requisicion_id'] = $registro['gt_tipo_requisicion_id'];
        $registros['etapa'] = 'ALTA';
        $registros['codigo'] = $this->modelo->get_codigo_aleatorio(12);
        $registros['descripcion'] = "Solicitud de requisición - ".$registros['codigo'];
        $alta = (new gt_requisicion($this->link))->alta_registro(registro: $registros);
        if (errores::$error) {
            $this->link->rollBack();
            return $this->retorno_error(mensaje: 'Error al dar de alta requisicion', data: $alta,
                header: $header, ws: $ws);
        }

        $this->link->commit();

        if ($header) {
            $this->retorno_base(registro_id: $this->registro_id, result: $alta,
                siguiente_view: "lista", ws: $ws);
        }
        if ($ws) {
            header('Content-Type: application/json');
            echo json_encode($alta, JSON_THROW_ON_ERROR);
            exit;
        }
        $alta->siguiente_view = "lista";

        return $alta;
    }

    protected function campos_view(array $inputs = array()): array
    {
        $keys = new stdClass();
        $keys->inputs = array('codigo', 'descripcion', 'cantidad', 'precio', 'descripcion2', 'observaciones');
        $keys->telefonos = array();
        $keys->fechas = array('fecha');
        $keys->selects = array();

        $init_data = array();
        $init_data['gt_centro_costo'] = "gamboamartin\\gastos";
        $init_data['gt_tipo_solicitud'] = "gamboamartin\\gastos";
        $init_data['gt_solicitante'] = "gamboamartin\\gastos";
        $init_data['gt_autorizante'] = "gamboamartin\\gastos";
        $init_data['gt_tipo_requisicion'] = "gamboamartin\\gastos";
        $init_data['em_empleado'] = "gamboamartin\\empleado";
        $init_data['com_producto'] = "gamboamartin\\comercial";
        $init_data['cat_sat_unidad'] = "gamboamartin\\cat_sat";

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

        $link = $this->obj_link->get_link(seccion: "gt_solicitud", accion: "autoriza_bd");
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al recuperar link autoriza_bd', data: $link);
            print_r($error);
            exit;
        }
        $this->link_autoriza_bd = $link;

        $link = $this->obj_link->get_link(seccion: "gt_solicitud", accion: "producto_bd");
        if (errores::$error) {
            $error = $this->errores->error(mensaje: 'Error al recuperar link producto_bd', data: $link);
            print_r($error);
            exit;
        }
        $this->link_producto_bd = $link;

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
        $keys_selects = $this->init_selects(keys_selects: $keys_selects, key: "gt_tipo_solicitud_id", label: "Tipo Solicitud", cols: 12);
        $keys_selects = $this->init_selects(keys_selects: $keys_selects, key: "gt_tipo_requisicion_id", label: "Tipo Requisición", cols: 12);
        $keys_selects = $this->init_selects(keys_selects: $keys_selects, key: "com_producto_id", label: "Producto", cols: 12);
        return $this->init_selects(keys_selects: $keys_selects, key: "cat_sat_unidad_id", label: "Unidad", cols: 12);
    }

    protected function key_selects_txt(array $keys_selects): array
    {
        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 4, key: 'codigo',
            keys_selects: $keys_selects, place_holder: 'Código');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'cantidad',
            keys_selects: $keys_selects, place_holder: 'Cantidad');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'precio',
            keys_selects: $keys_selects, place_holder: 'Precio');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 6, key: 'fecha',
            keys_selects: $keys_selects, place_holder: 'Fecha');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 12, key: 'descripcion2',
            keys_selects: $keys_selects, place_holder: 'Descripción');
        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 12, key: 'obervaciones',
            keys_selects: $keys_selects, place_holder: 'Obervaciones');
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

        $columns = array();
        $columns["gt_solicitud_producto_id"]["titulo"] = "Id";
        $columns["com_producto_descripcion"]["titulo"] = "Producto";
        $columns["cat_sat_unidad_descripcion"]["titulo"] = "Unidad";
        $columns["gt_solicitud_producto_cantidad"]["titulo"] = "Cantidad";
        $columns["gt_solicitud_producto_precio"]["titulo"] = "Precio";
        $columns["gt_solicitud_producto_total"]["titulo"] = "Total";
        $columns["elimina_bd"]["titulo"] = "Acciones";

        $filtro = array('gt_solicitud_id');
        $data["gt_solicitud.id"] = $this->registro_id;

        $datatables = $this->datatable_init(columns: $columns, filtro: $filtro, identificador: "#gt_solicitud_producto",
            data: $data, in: array(), multi_selects: true);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al inicializar datatable', data: $datatables,
                header: $header, ws: $ws);
        }

        return $r_modifica;
    }

    /**
     * Funcion que de alta una requisicion
     * @param array $datos datos de la solicitud
     * @param int $gt_tipo_requisicion_id id del tipo de requisicion a dar de alta
     * @return array|stdClass retorna el estado de la accion
     */
    private function alta_requisicion(array $datos, int $gt_tipo_requisicion_id) : array|stdClass
    {
        $registro = array();
        $registro['gt_solicitud_id'] = $datos['gt_solicitud_id'];
        $registro['gt_centro_costo_id'] = $datos['gt_centro_costo_id'];
        $registro['gt_tipo_requisicion_id'] = $gt_tipo_requisicion_id;
        $registro['descripcion'] = $this->modelo->get_codigo_aleatorio(10);
        $alta = (new gt_requisicion($this->link))->alta_registro(registro: $registro);
        if (errores::$error) {
            $this->link->rollBack();
            return $this->errores->error(mensaje: "Error al ejecutar alta",data: $alta);
        }

        return $alta;
    }

    /**
     * Funcion que de alta una requisicion-producto
     * @param stdClass $gt_requisicion datos de la requisicion
     * @param int $producto id del producto a relacionar
     * @param stdClass $datos datos de la solicitud producto
     * @return array|stdClass retorna el estado de la accion
     */
    private function alta_requisicion_producto(stdClass $gt_requisicion, int $producto, stdClass $datos) : array|stdClass
    {
        $registro = array();
        $registro['gt_requisicion_id'] = $gt_requisicion->registro_id;
        $registro['com_producto_id'] = $producto;
        $registro['cat_sat_unidad_id'] = $datos->registros[0]['cat_sat_unidad_id'];
        $registro['cantidad'] = $datos->registros[0]['gt_solicitud_producto_cantidad'];
        $registro['precio'] = $datos->registros[0]['gt_solicitud_producto_precio'];
        $alta = (new gt_requisicion_producto($this->link))->alta_registro(registro: $registro);
        if (errores::$error) {
            $this->link->rollBack();
            return $this->errores->error(mensaje: "Error al ejecutar alta",data: $alta);
        }

        return $alta;
    }

    /**
     * Funcion que de alta una solicitud_requisicion
     * @param stdClass $gt_requisicion datos de la requisicion
     * @return array|stdClass retorna el estado de la accion
     */
    private function alta_solicitud_requisicion(stdClass $gt_requisicion) : array|stdClass
    {
        $registro = array();
        $registro['gt_solicitud_id'] = $this->registro_id;
        $registro['gt_requisicion_id'] = $gt_requisicion->registro_id;
        $registro['descripcion'] = $_POST['descripcion2'];
        $registro['codigo'] = $this->modelo->get_codigo_aleatorio();
        $alta = (new gt_solicitud_requisicion($this->link))->alta_registro(registro: $registro);
        if (errores::$error) {
            $this->link->rollBack();
            return $this->errores->error(mensaje: "Error al ejecutar alta",data: $alta);
        }

        return $alta;
    }

    public function producto_bd(bool $header, bool $ws = false): array|stdClass
    {
        if (!isset($_POST['agregar_producto'])) {
            return $this->retorno_error(mensaje: 'Error no existe agregar_producto', data: $_POST, header: $header,
                ws: $ws);
        }

        $productos_seleccionados = explode(",", $_POST['agregar_producto']);

        if (count($productos_seleccionados) === 0) {
            return $this->retorno_error(mensaje: 'Error no ha seleccionado un producto', data: $_POST, header: $header,
                ws: $ws);
        }

        $this->link->beginTransaction();

        $siguiente_view = (new actions())->init_alta_bd();
        if (errores::$error) {
            $this->link->rollBack();
            return $this->retorno_error(mensaje: 'Error al obtener siguiente view', data: $siguiente_view,
                header: $header, ws: $ws);
        }

        if (isset($_POST['btn_action_next'])) {
            unset($_POST['btn_action_next']);
        }

        $datos = (new gt_solicitud($this->link))->registro(registro_id :$this->registro_id);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al obtener solicitud', data: $datos,
                header: $header, ws: $ws);
        }

        $gt_requisicion = $this->alta_requisicion(datos: $datos, gt_tipo_requisicion_id: $_POST['gt_tipo_requisicion_id']);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al dar de alta requisicion', data: $gt_requisicion,
                header: $header, ws: $ws);
        }

        foreach ($productos_seleccionados as $producto) {

            $filtro['gt_solicitud_id'] = $this->registro_id;
            $filtro['com_producto_id'] = $producto;
            $datos = (new gt_solicitud_producto($this->link))->filtro_and(filtro : $filtro);
            if (errores::$error) {
                $this->link->rollBack();
                return $this->retorno_error(mensaje: 'Error al obtener producto de la solicitud', data: $datos,
                    header: $header, ws: $ws);
            }

            if ($datos->n_registros <= 0){
                $this->link->rollBack();
                return $this->retorno_error(mensaje: 'Error no existe el producto asociado a la solicitud', data: $datos,
                    header: $header, ws: $ws);
            }

            $gt_requisicion_producto = $this->alta_requisicion_producto(gt_requisicion: $gt_requisicion,producto: $producto,datos: $datos);
            if (errores::$error) {
                return $this->retorno_error(mensaje: 'Error al dar de alta requisicion producto', data: $gt_requisicion_producto,
                    header: $header, ws: $ws);
            }
        }

        $this->link->commit();

        if ($header) {
            $this->retorno_base(registro_id: $this->registro_id, result: $gt_requisicion,
                siguiente_view: "modifica", ws: $ws);
        }
        if ($ws) {
            header('Content-Type: application/json');
            echo json_encode($gt_requisicion, JSON_THROW_ON_ERROR);
            exit;
        }
        $gt_requisicion->siguiente_view = "modifica";

        return $gt_requisicion;
    }

}
