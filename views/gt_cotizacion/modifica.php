<?php /** @var  \gamboamartin\gastos\controllers\controlador_gt_cotizacion $controlador controlador en ejecucion */ ?>
<?php use config\views; ?>

<main class="main section-color-primary">
    <div class="container">

        <div class="row">

            <div class="col-lg-12">

                <div class="widget  widget-box box-container form-main widget-form-cart" id="form" style="display: flex;">

                    <form method="post" action="<?php echo $controlador->link_modifica_bd; ?>" class="form-additional">
                        <?php include (new views())->ruta_templates . "head/title.php"; ?>
                        <?php include (new views())->ruta_templates . "head/subtitulo.php"; ?>
                        <?php include (new views())->ruta_templates . "mensajes.php"; ?>
                        <?php echo $controlador->inputs->gt_tipo_cotizacion_id; ?>
                        <?php echo $controlador->inputs->gt_centro_costo_id; ?>
                        <?php echo $controlador->inputs->descripcion; ?>
                        <?php //include (new views())->ruta_templates . 'botons/submit/modifica_bd.php'; ?>
                    </form>
                </div>

            </div>

        </div>
    </div>

</main>


















