<?php use config\views; ?>
<?php /** @var controllers\controlador_wt_hogar $controlador */ ?>
<?php /** @var stdClass $row  viene de registros del controler*/ ?>

<tr>
    <td><?php echo $row->gt_solicitud_id; ?></td>
    <td><?php echo $row->gt_solicitud_codigo_bis; ?></td>
    <td><?php echo $row->gt_solicitud_descripcion; ?></td>
    <td><?php echo $row->gt_solicitud_descripcion_select; ?></td>
    <td><?php echo $row->gt_solicitud_alias; ?></td>
    <td><?php echo $row->gt_solicitud_gt_centro_costo_id; ?></td>
    <td><?php echo $row->gt_solicitud_gt_tipo_solicitud_id; ?></td>


    <!-- End dynamic generated -->

    <?php include (new views())->ruta_templates.'listas/action_row.php';?>
</tr>