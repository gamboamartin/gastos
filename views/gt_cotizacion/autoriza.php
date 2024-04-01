<?php /** @var  \gamboamartin\gastos\controllers\controlador_gt_solicitante $controlador controlador en ejecucion */ ?>
<?php use config\views; ?>

<main class="main section-color-primary">
    <div class="container">

        <div class="row">

            <div class="col-lg-12">

                <div class="widget  widget-box box-container form-main widget-form-cart" id="form" >

                    <form method="post" action="<?php echo $controlador->link_autoriza_bd; ?>" class="form-additional">
                        <?php include (new views())->ruta_templates . "head/title.php"; ?>
                        <?php include (new views())->ruta_templates . "head/subtitulo.php"; ?>
                        <?php include (new views())->ruta_templates . "mensajes.php"; ?>
                        <?php echo $controlador->inputs->fecha; ?>
                        <div class="control-group">
                            <div class="controls" style="display: inline-flex;">
                                <input type="hidden" name="action" id="action">
                                <button class="btn btn-danger" id="rechazarBtn" style="margin-right: 15px;">Rechazar</button>
                                <button class="btn btn-success" id="autorizarBtn">Autorizar</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>

</main>


















