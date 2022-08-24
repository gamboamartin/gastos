<?php

use config\generales;
use config\views;
?>
<?php /** @var base\controller\controlador_base $controlador  viene de registros del controler/lista */
    //var_dump($controlador->inputs); exit;
//var_dump($controlador->inputs); exit;
?>


<section class="ftco-section img bg-hero" >


    <div class="container">
       <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h1 class="heading-section"><?php echo $controlador->row_upd->gt_proveedor_descripcion?></h1>
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
                            <div class="col-lg-5 bg-info " >

                                <div class="contact-wrap w-100 p-md-5 p-4">
                                    <h3 class="mb-4">Modifica</h3>
                                    <div class="row">
                                        <form method="post" action="./index.php?seccion=gt_proveedor&accion=ver_datos_fiscales&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>" class="form-additional" enctype="multipart/form-data">
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

                                        <div class="buttons col-md-12">
                                            <div class="col-md-6 btn-ancho">
                                                <button type="submit" class="btn btn-info btn-guarda col-md-12 " name="btn_action_next" value="modifica">Modifica</button>
                                            </div>
                                            <div class="col-md-6 btn-ancho">
                                                <button type="submit" class="btn btn-info btn-guarda col-md-12 " name="btn_action_next" value="ubicacion">Siguiente</button>
                                            </div>

                                        </div>


                                        </form>
                                    </div>
                                </div>

                            </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
