<?php /** @var base\controller\controlador_base $controlador  viene de registros del controler/lista */ ?>


<div class="control-group col-sm-12">
    <label class="control-label" for="descripcion">Descripcion</label>
    <div class="controls">
        <input type="text" name="descripcion" value="" class="form-control" required id="descripcion" placeholder="Descripcion">
    </div>
</div>

<?php echo $controlador->inputs->select->gt_centro_costo_id; ?>
<?php echo $controlador->inputs->select->gt_tipo_solicitud_id; ?>

<div class="control-group btn-alta">
    <div class="controls">
        <button type="submit" class="btn btn-success" name="guarda">Alta</button>
        <button type="submit" class="btn btn-success" name="guarda_otro">Genero Otro</button>
    </div>
</div>
