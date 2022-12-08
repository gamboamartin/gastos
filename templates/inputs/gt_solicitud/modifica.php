<?php /** @var gamboamartin\gastos\controllers\controlador_gt_tipo_solicitud $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>

<?php echo $controlador->inputs->codigo; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->select->gt_centro_costo_id; ?>
<?php echo $controlador->inputs->select->gt_tipo_solicitud_id; ?>

<?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>

<div class="col-row-12">
    <?php foreach ($controlador->buttons as $button){ ?>
        <?php echo $button; ?>
    <?php }?>
</div>
