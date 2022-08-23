<?php

use config\generales;
use config\views;
?>
<?php /** @var base\controller\controlador_base $controlador  viene de registros del controler/lista */
    //var_dump($controlador->inputs); exit;
//var_dump($controlador->inputs); exit;
?>


<section class="ftco-section img bg-hero" >
    <head>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <div class="container">
        <form method="post" action="./index.php?seccion=gt_provedor&accion=ver_datos_fiscales&session_id=<?php echo $controlador->session_id; ?>&registro_id=<?php echo $controlador->registro_id; ?>" class="form-additional">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section"><?php echo $controlador->row_upd->gt_proveedor_descripcion?></h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="wrapper">
                    <div class="row no-gutters justify-content-between">
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="info-wrap w-100 p-5">
                                <h3 class="mb-4">Datos Generales</h3>
                                <div class="dbox w-100 d-flex align-items-start">

                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-bandcamp"></span>
                                    </div>
                                    <div class="text pl-4">
                                        <p><span>Descripcion:</span><?php echo $controlador->row_upd->gt_proveedor_descripcion; ?></p>
                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-start">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-bandcamp"></span>
                                    </div>
                                    <div class="text pl-4">
                                        <p><span>Codigo:</span><?php echo $controlador->row_upd->gt_proveedor_codigo; ?></p>
                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-start">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-bandcamp"></span>
                                    </div>
                                    <div class="text pl-4">
                                        <p><span>Descripcion select:</span><?php echo $controlador->row_upd->gt_proveedor_descripcion_select; ?></p>
                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-start">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-bandcamp"></span>
                                    </div>
                                    <div class="text pl-4">
                                        <p><span>Alias:</span><?php echo $controlador->row_upd->gt_proveedor_alias; ?></p>
                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-start">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-bandcamp"></span>
                                    </div>
                                    <div class="text pl-4">
                                        <p><span>Codigo bis:</span><?php echo $controlador->row_upd->gt_proveedor_codigo_bis; ?></p>
                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-start">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-bandcamp"></span>
                                    </div>
                                    <div class="text pl-4">
                                        <p><span>Pagina web:</span><?php echo $controlador->row_upd->gt_proveedor_pagina_web; ?></p>
                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-start">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="fa fa-bandcamp"></span>
                                    </div>
                                    <div class="text pl-4">
                                        <p><span>Tipo proveedor:</span><?php echo $controlador->row_upd->gt_proveedor_gt_tipo_proveedor_id; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="contact-wrap w-100 p-md-5 p-4">
                                <h3 class="mb-4">Modifica</h3>
                                <div id="form-message-warning" class="mb-4"></div>
                                <div id="form-message-success" class="mb-4">
                                    Your message was sent, thank you!
                                </div>
                                <form method="POST" id="contactForm" name="contactForm">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label" for="descripcion">Descripcion</label>
                                                <div class="controls">
                                                    <input class="form-control input-lg" type="text" name="descripcion" value="<?php echo $controlador->row_upd->gt_proveedor_descripcion; ?>" class="form-control" required="" id="descripcion" placeholder="Descripcion">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label" for="descripcion_select">Descripcion Select</label>
                                                <div class="controls">
                                                    <input class="form-control input-lg" type="text" name="descripcion_select" value="<?php echo $controlador->row_upd->gt_proveedor_descripcion_select; ?>" class="form-control" required="" id="descripcion_select" placeholder="Descripcion Select">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label" for="alias">Alias</label>
                                                <div class="controls">
                                                    <input class="form-control input-lg" type="text" name="alias" value="<?php echo $controlador->row_upd->gt_proveedor_alias; ?>" class="form-control" required="" id="alias" placeholder="Alias">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label" for="url">Codigo bis</label>
                                                <div class="controls">
                                                    <input class="form-control input-lg" type="text" name="codigo_bis" value="<?php echo $controlador->row_upd->gt_proveedor_codigo_bis; ?>" class="form-control" required="" id="codigo_bis" placeholder="codigo bis">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label" for="img_descripcion">Pagina Web</label>
                                                <div class="controls">
                                                    <input class="form-control input-lg" type="text" name="pagina_web" value="<?php echo $controlador->row_upd->gt_proveedor_pagina_web; ?>" class="form-control" required="" id="pagina_web" placeholder="pagina_web">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="control-label" for="gt_tipo_proveedor">Tipo proveedor</label>
                                                <div class="controls" >
                                                    <?php echo $controlador->inputs->select->gt_tipo_proveedor_id; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="col-md-6 btn-ancho">

                                                    <button type="submit" class="btn btn-info btn-guarda col-md-12 " name="btn_action_next" value="modifica">Modifica</button>
                                                </div>
                                                <div class="col-md-6 btn-ancho">
                                                    <button type="submit" class="btn btn-info btn-guarda col-md-12 " name="btn_action_next" value="ubicacion">Siguiente</button>
                                                </div>
                                                <div class="submitting"></div>

                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</section>
