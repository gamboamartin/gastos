<?php /** @var  \gamboamartin\gastos\controllers\controlador_gt_proveedor $controlador  controlador en ejecucion */ ?>
<?php use config\views; ?>
<?php echo $controlador->inputs->razon_social; ?>
<?php echo $controlador->inputs->rfc; ?>
<?php echo $controlador->inputs->dp_pais_id; ?>
<?php echo $controlador->inputs->dp_estado_id; ?>
<?php echo $controlador->inputs->dp_municipio_id; ?>
<?php echo $controlador->inputs->dp_cp_id; ?>
<?php echo $controlador->inputs->dp_colonia_postal_id; ?>
<?php echo $controlador->inputs->dp_calle_pertenece_id; ?>
<?php echo $controlador->inputs->exterior; ?>
<?php echo $controlador->inputs->interior; ?>
<?php echo $controlador->inputs->cat_sat_regimen_fiscal_id; ?>
<?php echo $controlador->inputs->gt_tipo_proveedor_id; ?>
<?php echo $controlador->inputs->pagina_web; ?>
<?php echo $controlador->inputs->telefono_1; ?>
<?php echo $controlador->inputs->telefono_2; ?>
<?php echo $controlador->inputs->telefono_3; ?>
<?php echo $controlador->inputs->contacto_1; ?>
<?php echo $controlador->inputs->contacto_2; ?>
<?php echo $controlador->inputs->contacto_3; ?>
<?php include (new views())->ruta_templates.'botons/submit/alta_bd.php';?>