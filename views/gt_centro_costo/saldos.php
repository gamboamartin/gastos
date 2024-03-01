<?php /** @var  \gamboamartin\gastos\controllers\controlador_gt_centro_costo $controlador controlador en ejecucion */ ?>
<?php use config\views; ?>

<main class="main section-color-primary">
    <div class="container">

        <div class="row">

            <div class="col-md-12">

                <div class="widget  widget-box box-container form-main widget-form-cart" id="form" >

                    <?php include (new views())->ruta_templates . "head/title.php"; ?>
                    <?php include (new views())->ruta_templates . "head/subtitulo.php"; ?>
                    <?php include (new views())->ruta_templates . "mensajes.php"; ?>

                    <div class="table-responsive">
                        <table id="table-gt_orden_compra" class="table mb-0 table-striped table-sm "></table>
                    </div>

                </div>

            </div>

        </div>
    </div>

</main>


















