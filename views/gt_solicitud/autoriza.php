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
                        <?php echo $controlador->inputs->gt_solicitante_id; ?>
                        <?php echo $controlador->inputs->fecha; ?>
                        <?php echo $controlador->inputs->observaciones; ?>
                        <div class="control-group">
                            <div class="controls" style="display: inline-flex;">
                                <button class="btn btn-danger" role="submit" style="margin-right: 15px;">Rechazar</button><br>
                                <button class="btn btn-success" role="submit">Autorizar</button><br>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>

</main>


















