<?php

use config\generales;
use config\views;
?>
<?php /** @var base\controller\controlador_base $controlador  viene de registros del controler/lista */
//var_dump($controlador->inputs); exit;
//var_dump($controlador->inputs); exit;
?>




<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

<section class="ftco-section " style=" center;">


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
                                <h3 class="mb-4">Datos Fiscales</h3>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="img_descripcion">    </label>
                                        <label class="control-label" for="img_descripcion">    </label>
                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-start">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <a class="fa fa-bandcamp" style="color:#00008B; font-size: 30px"  href="./index.php?seccion=gt_proveedor&accion=proveedor_datos_generales&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>" >  Datos Generales</a>
                                    </div>
                                    
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="img_descripcion">    </label>

                                    </div>
                                </div>

                                <div class="dbox w-100 d-flex align-items-start">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <a class="fa fa-bandcamp" style="color:#00008B; font-size: 30px"  href="./index.php?seccion=gt_proveedor&accion=proveedor_datos_fiscales&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>">  Datos Fiscales</a>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="img_descripcion">    </label>

                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-start">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <a class="fa fa-bandcamp" style="color:#00008B; font-size: 30px"  href="./index.php?seccion=gt_proveedor&accion=proveedor_datos_generales&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>">  Datos De contacto</a>
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
                                            <label class="control-label" for="rfc">RFC</label>
                                            <div class="controls">
                                                <input class="form-control input-lg" type="text" name="rfc" value="<?php echo $controlador->row_upd->descripcion; ?>" class="form-control" required="" id="rfc" placeholder="RFC">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label" for="cat_sat_regimen_fiscal">Regimen Fiscal</label>
                                            <div class="controls">
                                                <?php echo $controlador->inputs->select->cat_sat_regimen_fiscal_id; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label" for="dp_calle_pertenece">Calle</label>
                                            <div class="controls">
                                                <?php echo $controlador->inputs->select->dp_calle_pertenece_id; ?>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label" for="exterior">Exterior</label>
                                            <div class="controls">
                                                <input type="text" name="exterior" value="" class="form-control" required="" id="exterior" placeholder="Exterior">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="control-label" for="interior">Interior</label>
                                            <div class="controls">
                                                <input type="text" name="interior" value="" class="form-control" required="" id="interior" placeholder="Interior">
                                            </div>
                                        </div>
                                    </div>


                                            <label class="control-label" for="img_descripcion">    </label>

                                    <div class="buttons col-md-12" style="text-align: center;">
                                        <p>


                                            <a href="./index.php?seccion=gt_proveedor&accion=proveedor_datos_generales&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info"><i class=""></i>
                                                Anterior
                                            </a>


                                            <a href="./index.php?seccion=gt_proveedor&accion=modifica_datos_fiscales&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info"><i class=""></i>
                                                Modifica
                                            </a>


                                            <a href="./index.php?seccion=gt_proveedor&accion=proveedor_datos_contactos&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info"><i class=""></i>
                                                Siguiente
                                            </a>

                                        </p>
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
