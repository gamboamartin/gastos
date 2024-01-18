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
use gamboamartin\gastos\models\gt_cotizacion;
use gamboamartin\gastos\models\gt_cotizacion_producto;
use gamboamartin\gastos\models\gt_orden_compra;
use gamboamartin\gastos\models\gt_orden_compra_cotizacion;
use gamboamartin\gastos\models\gt_orden_compra_producto;
use gamboamartin\gastos\models\gt_requisicion;
use gamboamartin\gastos\models\gt_requisicion_etapa;
use gamboamartin\gastos\models\gt_solicitud;
use gamboamartin\gastos\models\gt_solicitud_etapa;
use gamboamartin\proceso\models\pr_etapa_proceso;
use gamboamartin\system\_ctl_parent_sin_codigo;
use gamboamartin\system\actions;
use gamboamartin\system\links_menu;
use gamboamartin\template\html;
use html\gt_autorizante_html;
use html\gt_cotizacion_html;
use html\gt_requisicion_html;
use html\gt_solicitante_html;
use html\gt_solicitud_html;
use html\gt_centro_costo_html;
use html\gt_tipo_solicitud_html;
use PDO;
use stdClass;

class controlador_gt_cotizacion extends _ctl_parent_sin_codigo {

    public string $link_partidas = '';
    public string $link_producto_bd = '';

    public function __construct(PDO      $link, html $html = new \gamboamartin\template_1\html(),
                                stdClass $paths_conf = new stdClass())
    {
        $modelo = new gt_cotizacion(link: $link);
        $html_ = new gt_cotizacion_html(html: $html);
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
        $keys->inputs = array('codigo', 'descripcion', 'cantidad', 'precio', 'descripcion2');
        $keys->telefonos = array();
        $keys->fechas = array('fecha');
        $keys->selects = array();

        $init_data = array();
        $init_data['gt_centro_costo'] = "gamboamartin\\gastos";
        $init_data['gt_tipo_cotizacion'] = "gamboamartin\\gastos";
        $init_data['gt_proveedor'] = "gamboamartin\\gastos";

        $init_data['gt_requisitor'] = "gamboamartin\\gastos";
        $init_data['gt_autorizante'] = "gamboamartin\\gastos";
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
        $this->seccion_titulo = 'Cotización';
        $this->titulo_lista = 'Registro de Cotización';

        $this->lista_get_data = true;

        return $this;
    }

    protected function init_datatable(): stdClass
    {
        $columns["gt_cotizacion_id"]["titulo"] = "Id";
        $columns["gt_tipo_cotizacion_descripcion"]["titulo"] = "Tipo";
        $columns["gt_proveedor_descripcion"]["titulo"] = "Proveedor";
        $columns["gt_centro_costo_descripcion"]["titulo"] = "Centro Costo";
        $columns["gt_cotizacion_descripcion"]["titulo"] = "Descripción";

        $filtro = array("gt_cotizacion.id","gt_proveedor.descripcion","gt_tipo_cotizacion.descripcion","gt_centro_costo.descripcion",
            "gt_cotizacion.descripcion");

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

        $link = $this->obj_link->get_link(seccion: "gt_cotizacion", accion: "producto_bd");
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
        $keys_selects = $this->init_selects(keys_selects: $keys_selects, key: "gt_proveedor_id", label: "Proveedor", cols: 12);
        $keys_selects = $this->init_selects(keys_selects: $keys_selects, key: "em_empleado_id", label: "Empleado", cols: 12);
        $keys_selects = $this->init_selects(keys_selects: $keys_selects, key: "gt_requisitor_id", label: "Requisitor", cols: 12);
        $keys_selects = $this->init_selects(keys_selects: $keys_selects, key: "gt_autorizante_id", label: "Autorizante", cols: 12);
        $keys_selects = $this->init_selects(keys_selects: $keys_selects, key: "gt_tipo_cotizacion_id", label: "Tipo Cotización", cols: 12);
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
        $keys_selects['gt_tipo_cotizacion_id']->id_selected = $this->registro['gt_tipo_cotizacion_id'];
        $keys_selects['gt_proveedor_id']->id_selected = $this->registro['gt_proveedor_id'];

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 12, key: 'descripcion',
            keys_selects: $keys_selects, place_holder: 'Descripción');
        $keys_selects['descripcion']->disabled = true;
        $keys_selects['gt_centro_costo_id']->disabled = true;
        $keys_selects['gt_tipo_cotizacion_id']->disabled = true;
        $keys_selects['gt_proveedor_id']->disabled = true;

        if (errores::$error) {
            return $this->errores->error(mensaje: 'Error al maquetar key_selects', data: $keys_selects);
        }

        $base = $this->base_upd(keys_selects: $keys_selects, params: array(), params_ajustados: array());
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al integrar base', data: $base, header: $header, ws: $ws);
        }

        $columns = array();
        $columns["gt_cotizacion_producto_id"]["titulo"] = "Id";
        $columns["com_producto_descripcion"]["titulo"] = "Producto";
        $columns["cat_sat_unidad_descripcion"]["titulo"] = "Unidad";
        $columns["gt_cotizacion_producto_cantidad"]["titulo"] = "Cantidad";
        $columns["gt_cotizacion_producto_precio"]["titulo"] = "Precio";
        $columns["gt_cotizacion_producto_total"]["titulo"] = "Total";
        $columns["elimina_bd"]["titulo"] = "Acciones";

        $filtro = array('gt_cotizacion_id');
        $data["gt_cotizacion.id"] = $this->registro_id;

        $datatables = $this->datatable_init(columns: $columns, filtro: $filtro, identificador: "#gt_cotizacion_producto",
            data: $data, in: array(), multi_selects: true);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al inicializar datatable', data: $datatables,
                header: $header, ws: $ws);
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

        $keys_selects['gt_tipo_cotizacion_id']->id_selected = $this->registro['gt_tipo_cotizacion_id'];
        $keys_selects['gt_proveedor_id']->id_selected = $this->registro['gt_proveedor_id'];
        $keys_selects['gt_centro_costo_id']->id_selected = $this->registro['gt_centro_costo_id'];

        $keys_selects = (new \base\controller\init())->key_select_txt(cols: 12, key: 'descripcion',
            keys_selects: $keys_selects, place_holder: 'Descripción');
        $keys_selects['descripcion']->disabled = true;
        $keys_selects['gt_tipo_cotizacion_id']->disabled = true;
        $keys_selects['gt_proveedor_id']->disabled = true;
        $keys_selects['gt_centro_costo_id']->disabled = true;

        $base = $this->base_upd(keys_selects: $keys_selects, params: array(), params_ajustados: array());
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al integrar base', data: $base, header: $header, ws: $ws);
        }

        return $r_modifica;
    }

    private function alta_orden_compra(array $datos)
    {
        $registro = array();
        $registro['descripcion'] = $datos['descripcion2'];
        $registro['codigo'] = $this->modelo->get_codigo_aleatorio();
        $alta = (new gt_orden_compra($this->link))->alta_registro(registro: $registro);
        if (errores::$error) {
            $this->link->rollBack();
            return $this->errores->error(mensaje: "Error al ejecutar alta",data: $alta);
        }

        return $alta;
    }

    private function alta_orden_compra_producto(stdClass $gt_orden_compra, int $producto, stdClass $datos)
    {
        $registro = array();
        $registro['gt_orden_compra_id'] = $gt_orden_compra->registro_id;
        $registro['com_producto_id'] = $producto;
        $registro['cat_sat_unidad_id'] = $datos->registros[0]['cat_sat_unidad_id'];
        $registro['cantidad'] = $datos->registros[0]['gt_cotizacion_producto_cantidad'];
        $registro['precio'] = $datos->registros[0]['gt_cotizacion_producto_precio'];
        $alta = (new gt_orden_compra_producto($this->link))->alta_registro(registro: $registro);
        if (errores::$error) {
            $this->link->rollBack();
            return $this->errores->error(mensaje: "Error al ejecutar alta",data: $alta);
        }

        return $alta;
    }

    private function alta_orden_compra_cotizacion(stdClass $gt_orden_compra)
    {
        $registro = array();
        $registro['gt_cotizacion_id'] = $this->registro_id;
        $registro['gt_orden_compra_id'] = $gt_orden_compra->registro_id;
        $registro['descripcion'] = $_POST['descripcion2'];
        $registro['codigo'] = $this->modelo->get_codigo_aleatorio();
        $alta = (new gt_orden_compra_cotizacion($this->link))->alta_registro(registro: $registro);
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

        $gt_orden_compra = $this->alta_orden_compra(datos: $_POST);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al dar de alta orden compra', data: $gt_orden_compra,
                header: $header, ws: $ws);
        }

        foreach ($productos_seleccionados as $producto) {

            $filtro['gt_cotizacion_id'] = $this->registro_id;
            $filtro['com_producto_id'] = $producto;
            $datos = (new gt_cotizacion_producto($this->link))->filtro_and(filtro : $filtro);
            if (errores::$error) {
                $this->link->rollBack();
                return $this->retorno_error(mensaje: 'Error al obtener producto de la cotizacion', data: $datos,
                    header: $header, ws: $ws);
            }

            if ($datos->n_registros <= 0){
                $this->link->rollBack();
                return $this->retorno_error(mensaje: 'Error no existe el producto asociado a la cotizacion', data: $producto,
                    header: $header, ws: $ws);
            }

            $gt_orden_compra_producto = $this->alta_orden_compra_producto(gt_orden_compra: $gt_orden_compra, producto: $producto,
                datos: $datos);
            if (errores::$error) {
                return $this->retorno_error(mensaje: 'Error al dar de alta compra producto', data: $gt_orden_compra_producto,
                    header: $header, ws: $ws);
            }
        }

        $gt_orden_compra_cotizacion = $this->alta_orden_compra_cotizacion(gt_orden_compra: $gt_orden_compra);
        if (errores::$error) {
            return $this->retorno_error(mensaje: 'Error al dar de alta relacion compra y cotizacion', data: $gt_orden_compra_cotizacion,
                header: $header, ws: $ws);
        }

        $this->link->commit();

        if ($header) {
            $this->retorno_base(registro_id: $this->registro_id, result: $gt_orden_compra_cotizacion,
                siguiente_view: "modifica", ws: $ws);
        }
        if ($ws) {
            header('Content-Type: application/json');
            echo json_encode($gt_orden_compra_cotizacion, JSON_THROW_ON_ERROR);
            exit;
        }
        $gt_orden_compra_cotizacion->siguiente_view = "modifica";

        return $gt_orden_compra_cotizacion;
    }
}
