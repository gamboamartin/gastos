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
use html\al_almacen_html;
use models\al_almacen;
use PDO;
use stdClass;

class controlador_al_almacen extends system {

    public function __construct(PDO $link, stdClass $paths_conf = new stdClass()){
        $modelo = new al_almacen(link: $link);
        $html_base = new html();
        $html = new al_almacen_html(html: $html_base);
        $obj_link = new links_menu($this->registro_id);
        parent::__construct(html:$html, link: $link,modelo:  $modelo, obj_link: $obj_link, paths_conf: $paths_conf);

        $this->titulo_lista = 'Almacen';

    }
}
