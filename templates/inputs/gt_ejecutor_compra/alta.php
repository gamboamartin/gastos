<?php /** @var  \gamboamartin\gastos\controllers\controlador_gt_ejecutor_compra $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->em_empleado_id; ?>
<?php echo $controlador->inputs->codigo; ?>
<?php include (new views())->ruta_templates.'botons/submit/alta_bd.php';?>