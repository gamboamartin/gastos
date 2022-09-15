<?php /** @var base\controller\controlador_base $controlador  viene de registros del controler/lista */ ?>

<?php
use config\generales;
use config\views;
?>
<div class="widget  widget-box box-container form-main widget-form-cart" id="form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <section class="top-title">
                    <ul class="breadcrumb">
                        <li class="item"><a href="./index.php?seccion=adm_session&accion=inicio&session_id=<?php echo $controlador->session_id; ?>"> Inicio </a></li>
                        <li class="item"><a href="./index.php?seccion=gt_solicitud&accion=lista&session_id=<?php echo $controlador->session_id; ?>"> Lista </a></li>
                        <?php //var_dump($controlador->row_upd); exit; ?>
                        <li class="item"> Asignar Solicitante </li>
                    </ul>    <h1 class="h-side-title page-title page-title-big text-color-primary"><?php echo strtoupper($controlador->row_upd->gt_solicitud_codigo)?></h1>
                </section> <!-- /. content-header -->
                <div class="widget  widget-box box-container form-main widget-form-cart" id="form">
                    <div class="widget-header">
                        <h2>Asignar Solicitante</h2>
                    </div>
                    <div>
                        <form method="post" action="./index.php?seccion=gt_autorizantes&accion=alta_bd&session_id=<?php echo $controlador->session_id; ?>&registro_id=<?php echo $controlador->registro_id; ?>" class="form-additional">

                            <?php echo $controlador->inputs->select->gt_solicitud_id; ?>
                            <?php echo $controlador->inputs->select->gt_autorizante_id; ?>
                            <input type="hidden" name="gt_solicitud_id" value="<?php echo $controlador->registro_id ?>">
                            <?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>
                        </form>
                    </div>

                </div>
            </div><!-- /.center-content -->
        </div>
    </div>
</div>