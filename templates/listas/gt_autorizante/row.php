<?php use config\views; ?>
<?php /** @var controllers\controlador_wt_hogar $controlador */ ?>
<?php /** @var stdClass $row  viene de registros del controler*/ ?>

<tr>
    <td><?php echo $row->gt_autorizante_id; ?></td>
    <td><?php echo $row->gt_autorizante_codigo; ?></td>
    <td><?php echo $row->gt_autorizante_codigo_bis; ?></td>
    <td><?php echo $row->gt_autorizante_descripcion; ?></td>
    <td><?php echo $row->gt_autorizante_descripcion_select; ?></td>
    <td><?php echo $row->gt_autorizante_em_empleado_id; ?></td>

    <!-- End dynamic generated -->

    <?php include (new views())->ruta_templates.'listas/action_row.php';?>
</tr>