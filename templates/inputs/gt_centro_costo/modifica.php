<?php /** @var base\controller\controlador_base $controlador  viene de registros del controler/lista */ ?>

<?php
use config\generales;
use config\views;
?>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet"/>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
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
<div class="control-group col-sm-6">
    <label class="control-label" for="descripcion_select">Descripcion Select</label>
    <div class="controls">
        <input type="text" name="descripcion_select" value="<?php echo $controlador->row_upd->descripcion_select; ?>" class="form-control" required="" id="descripcion_select" placeholder="Descripcion Select">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="codigo">Codigo</label>
    <div class="controls">
        <input type="text" name="codigo" value="<?php echo $controlador->row_upd->codigo; ?>" class="form-control" required="" id="codigo" placeholder="Codigo">
    </div>
</div>
    <div class="control-group col-sm-6">
        <label class="control-label" for="alias">Alias</label>
        <div class="controls">
            <input type="text" name="alias" value="<?php echo $controlador->row_upd->alias; ?>" class="form-control" required="" id="alias" placeholder="alias">
        </div>
    </div>
    <div class="control-group col-sm-6">
        <label class="control-label" for="codigo_bis">Codigo bis</label>
        <div class="controls">
            <input type="text" name="codigo_bis" value="<?php echo $controlador->row_upd->codigo_bis; ?>" class="form-control" required="" id="codigo_bis" placeholder="Codigo bis">
        </div>
    </div>
    <div class="col-md-12">
        <label class="control-label" for="gt_tipo_centro_costo">Tipo centro costo</label>
        <div class="controls">
            <?php echo $controlador->inputs->select->gt_tipo_centro_costo_id; ?>
        </div>
    </div>

<?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>