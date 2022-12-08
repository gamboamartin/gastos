<?php /** @var gamboamartin\gastos\controllers\controlador_gt_tipo_solicitud $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php echo $controlador->inputs->select->gt_centro_costo_id; ?>
<?php echo $controlador->inputs->select->gt_tipo_solicitud_id; ?>

<?php include (new views())->ruta_templates.'botons/submit/alta_bd_otro.php';?>
