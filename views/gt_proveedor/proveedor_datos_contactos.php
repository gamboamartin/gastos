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

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label" for="img_descripcion">    </label>
                                        <label class="control-label" for="img_descripcion">    </label>
                                    </div>
                                </div>
                                <div class="dbox w-100 d-flex align-items-start">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <a class="fa fa-bandcamp" style="color:#00008B; font-size: 30px" href="./index.php?seccion=gt_proveedor&accion=proveedor_datos_generales&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>" >  Datos Generales</a>
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
                                    <a class="fa fa-bandcamp" style=" font-size: 30px"  href="./index.php?seccion=gt_proveedor&accion=proveedor_datos_contactos&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>" >  Datos De Contactos</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-6 bg-info " style=" margin-bottom: 10%;" >
                            <form method="post" action="./index.php?seccion=gt_proveedor&accion=&accion=modifica_bd&session_id=<?php echo $controlador->session_id; ?>&registro_id=<?php echo $controlador->registro_id; ?>" class="form-additional">

                                <h3 class="mb-4">Modifica</h3>

                                <div class="control-group col-sm-6">
                                    <label class="control-label" for="contacto_1">Contacto 1</label>
                                    <div class="controls">
                                        <input type="text" name="contacto_1" value="<?php echo $controlador->row_upd->contacto_1; ?>" class="form-control" required="" id="contacto_1" placeholder="Contacto 1">
                                    </div>
                                </div>
                                <div class="control-group col-sm-6">
                                    <label class="control-label" for="telefono_1">Telefono 1</label>
                                    <div class="controls">
                                        <input type="text" name="telefono_1" value="<?php echo $controlador->row_upd->telefono_1; ?>" class="form-control" required="" id="telefono_1" placeholder="Telefono 1">
                                    </div>
                                </div>
                                <div class="control-group col-sm-6">
                                    <label class="control-label" for="contacto_2">Contacto 2</label>
                                    <div class="controls">
                                        <input type="text" name="contacto_2" value="<?php echo $controlador->row_upd->contacto_2; ?>" class="form-control" required="" id="contacto_2" placeholder="Contacto 2">
                                    </div>
                                </div>
                                <div class="control-group col-sm-6">
                                    <label class="control-label" for="telefono_2">Telefono 2</label>
                                    <div class="controls">
                                        <input type="text" name="telefono_2" value="<?php echo $controlador->row_upd->telefono_2; ?>" class="form-control" required="" id="telefono_2" placeholder="Telefono 2">
                                    </div>
                                </div>
                                <div class="control-group col-sm-6">
                                    <label class="control-label" for="contacto_3">Contacto 3</label>
                                    <div class="controls">
                                        <input type="text" name="contacto_3" value="<?php echo $controlador->row_upd->contacto_3; ?>" class="form-control" required="" id="contacto_3" placeholder="Contacto 3">
                                    </div>
                                </div>
                                <div class="control-group col-sm-6" style="margin-bottom: 2%;">
                                    <label class="control-label" for="telefono_3">Telefono 3</label>
                                    <div class="controls">
                                        <input type="text" name="telefono_3" value="<?php echo $controlador->row_upd->telefono_1; ?>" class="form-control" required="" id="telefono_3" placeholder="Telefono 3">
                                    </div>
                                </div>




                                <div class="buttons col-md-12" style="text-align: center; margin-bottom: 10%;" >
                                    <p></p>
                                    <label class="control-label" for="img_descripcion">    </label>
                                    <div class="col-md-6 btn-ancho">
                                        <a href="./index.php?seccion=gt_proveedor&accion=proveedor_datos_fiscales&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info"><i class=""></i>
                                            Anterior
                                        </a>
                                    </div>
                                    <div class="col-md-6 btn-ancho">

                                        <?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>

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

    </div>
</section>
