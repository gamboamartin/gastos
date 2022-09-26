<?php /** @var base\controller\controlador_base $controlador  viene de registros del controler/lista */ ?>

<?php
use config\generales;
use config\views;
use models\gt_autorizante;

?>
<div class="control-group col-sm-6">
    <label class="control-label" for="id">Id</label>
    <div class="controls">
        <input type="text" name="id" value="<?php echo $controlador->row_upd->id; ?>" class="form-control" required="" id="id" placeholder="Id" readonly>
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="descripcion">Descripcion</label>
    <div class="controls">
        <input type="text" name="descripcion" value="<?php echo $controlador->row_upd->descripcion; ?>" class="form-control" required="" id="descripcion" placeholder="Descripcion">
    </div>
</div>

<?php echo $controlador->inputs->select->gt_centro_costo_id; ?>
<?php echo $controlador->inputs->select->gt_tipo_solicitud_id; ?>

<?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>