<?php /** @var  \gamboamartin\gastos\controllers\controlador_gt_orden_compra_etapa  $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->gt_orden_compra_id; ?>
<?php echo $controlador->inputs->pr_etapa_proceso_id; ?>
<?php echo $controlador->inputs->fecha; ?>
<?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>