<?php /** @var gamboamartin\gastos\controllers\controlador_gt_tipo_centro_costo $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->descripcion; ?>
<?php include (new views())->ruta_templates.'botons/submit/alta_bd.php';?>
