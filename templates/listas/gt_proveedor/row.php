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

    <!-- End dynamic generated -->

    <?php include (new views())->ruta_templates.'listas/action_row.php';?>
</tr>