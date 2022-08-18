<?php
/**
 * @author Martin Gamboa Vazquez
 * @version 1.0.0
 * @created 2022-05-14
 * @final En proceso
 *
 */
namespace gamboamartin\gastos\controllers;

use config\generales;
use gamboamartin\errores\errores;
use gamboamartin\system\links_menu;
use gamboamartin\system\system;
use gamboamartin\template\html;
use html\gt_proveedor_html;
use models\gt_proveedor;
use PDO;
use stdClass;

class controlador_gt_proveedor extends system {

    public function __construct(PDO $link, stdClass $paths_conf = new stdClass()){
        $modelo = new gt_proveedor(link: $link);
        $html_base = new html();
        $html = new gt_proveedor_html(html: $html_base);
        $obj_link = new links_menu($this->registro_id);
        $this->rows_lista[] = 'gt_tipo_proveedor_id';
        $this->rows_lista[] = 'dp_calle_pertenece_id';
        $this->rows_lista[] = 'cat_sat_regimen_fiscal_id';
        $this->rows_lista[] = 'rfc';
        $this->rows_lista[] = 'exterior';
        $this->rows_lista[] = 'interior';
        $this->rows_lista[] = 'telefono_1';
        $this->rows_lista[] = 'telefono_2';
        $this->rows_lista[] = 'telefono_3';
        $this->rows_lista[] = 'contacto_1';
        $this->rows_lista[] = 'contacto_2';
        $this->rows_lista[] = 'contacto_3';
        $this->rows_lista[] = 'pagina_web';
        parent::__construct(html:$html, link: $link,modelo:  $modelo, obj_link: $obj_link, paths_conf: $paths_conf);

        $this->titulo_lista = 'Proveedor';

    }

    public function ver_datos_fiscales(bool $header, bool $ws = false, string $breadcrumbs = '',
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
}
