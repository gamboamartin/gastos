<?php use config\views; ?>
<?php /** @var controllers\controlador_wt_hogar $controlador */ ?>
<?php /** @var stdClass $row  viene de registros del controler*/ ?>

<tr>
    <td><?php echo $row->gt_proveedor_id; ?></td>
    <td><?php echo $row->gt_proveedor_descripcion; ?></td>
    <td><?php echo $row->gt_proveedor_gt_tipo_proveedor_id; ?></td>
    <td>
        <a href="./index.php?seccion=gt_proveedor&accion=proveedor_datos_fiscales&registro_id=<?php echo $row->gt_proveedor_id; ?>&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info"><i class=""></i>
            Datos Fiscales
        </a>
    </td>
    <td>
        <a href="<?php echo $row->gt_proveedor_pagina_web?>" target="_blank" class="btn btn-info"><i class=""></i>
            Pagina Web
        </a>
    </td>

    <!-- End dynamic generated -->

    <?php include (new views())->ruta_templates.'listas/action_row.php';?>
</tr>