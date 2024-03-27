<?php /** @var  \gamboamartin\gastos\controllers\controlador_gt_requisitor_solicitantes $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->gt_requisitor_id; ?>
<?php echo $controlador->inputs->gt_solicitante_id; ?>
<?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>