<?php

use config\generales;
use config\views;
?>
<?php /** @var base\controller\controlador_base $controlador  viene de registros del controler/lista */
    //var_dump($controlador->inputs); exit;
//var_dump($controlador->inputs); exit;
?>




<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<section class="ftco-section " >


    <div class="container center">
       <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h1 class="heading-section"><?php echo $controlador->row_upd->descripcion?></h1>
            </div>
       </div>
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="wrapper">
                    <div class="row no-gutters justify-content-between">
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="info-wrap w-100 p-5">
                                <h3 class="mb-4">Datos Generales</h3>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="img_descripcion">    </label>
                                        <label class="control-label" for="img_descripcion">    </label>
                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-start">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <a class="fa fa-bandcamp" style="color:#00008B; font-size: 30px"  href="./index.php?seccion=gt_proveedor&accion=ver_datos_fiscales&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>" >  Datos Generales</a>
                                    </div>
                                    <div class="text pl-4">
                                        <h4><span>       Descripcion:  </span><?php echo $controlador->row_upd->descripcion; ?></h4>
                                    </div>
                                    <div class="text pl-4">
                                        <h4><span>       Codigo:  </span><?php echo $controlador->row_upd->codigo; ?></h4>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="img_descripcion">    </label>

                                    </div>
                                </div>

                                <div class="dbox w-100 d-flex align-items-start">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <a class="fa fa-bandcamp" style="color:#00008B; font-size: 30px"  href="./index.php?seccion=gt_proveedor&accion=ver_datos_fiscales1&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>">  Datos Fiscales</a>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="img_descripcion">    </label>

                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-start">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <a class="fa fa-bandcamp" style="color:#00008B; font-size: 30px"  href="./index.php?seccion=gt_proveedor&accion=ver_datos_fiscales2&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>">  Datos De contacto</a>
                                    </div>

                                </div>

                            </div>
                        </div>
                            <div class="col-lg-6 bg-info " >

                                <div class="contact-wrap w-100 p-md-5 p-4">
                                    <h3 class="mb-4">Modifica</h3>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label" for="descripcion">Descripcion</label>
                                                    <div class="controls">
                                                        <input class="form-control input-lg" type="text" name="descripcion" value="<?php echo $controlador->row_upd->descripcion; ?>" class="form-control" required="" id="descripcion" placeholder="Descripcion">
                                                     </div>
                                                </div>
                                            </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label" for="codigo">Codigo</label>
                                                        <div class="controls">
                                                            <input type="text" name="Codigo" value="<?php echo $controlador->row_upd->codigo; ?>" class="form-control" required="" id="codigo" placeholder="Codigo" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label" for="descripcion_select">Descripcion Select</label>
                                                    <div class="controls">
                                                        <input class="form-control input-lg" type="text" name="descripcion_select" value="<?php echo $controlador->row_upd->descripcion_select; ?>" class="form-control" required="" id="descripcion_select" placeholder="Descripcion Select">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group " >
                                                    <label class="control-label" for="alias">Alias</label>
                                                    <div class="controls">
                                                        <input class="form-control input-lg" type="text" name="alias" value="<?php echo $controlador->row_upd->alias; ?>" class="form-control" required="" id="alias" placeholder="Alias">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label" for="url">Codigo bis</label>
                                                    <div class="controls">
                                                        <input class="form-control input-lg" type="text" name="codigo_bis" value="<?php echo $controlador->row_upd->codigo_bis; ?>" class="form-control" required="" id="codigo_bis" placeholder="codigo bis">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label" for="img_descripcion">Pagina Web</label>
                                                    <div class="controls">
                                                        <input class="form-control input-lg" type="text" name="pagina_web" value="<?php echo $controlador->row_upd->pagina_web; ?>" class="form-control" required="" id="pagina_web" placeholder="pagina_web">
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

                                            <div class="buttons col-md-12" style="text-align: center;">
                                                <p></p>
                                                <div class="col-md-6 btn-ancho">

                                                    <a href="./index.php?seccion=gt_proveedor&accion=modifica_datos_fiscales&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info"><i class=""></i>
                                                        Modifica
                                                    </a>
                                                </div>
                                                <div class="col-md-6 btn-ancho">
                                                    <a href="./index.php?seccion=gt_proveedor&accion=ver_datos_fiscales1&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info"><i class=""></i>
                                                        Siguiente
                                                    </a>
                                                </div>
                                            </div>
                                        </div>




                                </div>

                            </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
