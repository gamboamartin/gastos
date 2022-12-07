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
use html\gt_tipo_centro_costo_html;
use models\gt_tipo_centro_costo;
use PDO;
use stdClass;

class controlador_gt_tipo_centro_costo extends system {

    public function __construct(PDO $link, html $html = new \gamboamartin\template_1\html(), stdClass $paths_conf = new stdClass()){
        $modelo = new gt_tipo_centro_costo(link: $link);

        $html = new gt_tipo_centro_costo_html(html: $html);
        $obj_link = new links_menu(link: $link, registro_id:$this->registro_id);
        parent::__construct(html:$html, link: $link,modelo:  $modelo, obj_link: $obj_link, paths_conf: $paths_conf);

        $this->titulo_lista = 'Tipo Centro Costo';

    }
}
