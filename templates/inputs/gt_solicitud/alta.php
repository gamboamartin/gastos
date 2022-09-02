<?php /** @var base\controller\controlador_base $controlador  viene de registros del controler/lista */ ?>


<div class="control-group col-sm-6">
    <label class="control-label" for="descripcion">Descripcion</label>
    <div class="controls">
        <input type="text" name="descripcion" value="" class="form-control" required="" id="descripcion" placeholder="Descripcion">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="codigo">Codigo</label>
    <div class="controls">
        <input type="text" name="codigo" value="" class="form-control" required="" id="codigo" placeholder="Codigo">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="descripcion_select">Descripcion select</label>
    <div class="controls">
        <input type="text" name="descripcion_select" value="" class="form-control" required="" id="descripcion_select" placeholder="Descripcion select">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="alias">Alias</label>
    <div class="controls">
        <input type="text" name="alias" value="" class="form-control" required="" id="alias" placeholder="alias">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="codigo_bis">Codigo bis</label>
    <div class="controls">
        <input type="text" name="codigo_bis" value="" class="form-control" required="" id="codigo_bis" placeholder="Codigo bis">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="gt_tipo_centro_costo">Centro costo</label>
    <div class="controls">
        <?php echo $controlador->inputs->select->gt_centro_costo_id; ?>
    </div>

</div>

<div class="control-group col-sm-6">
    <label class="control-label" for="gt_tipo_centro_costo">Solicitud</label>
    <div class="controls">
        <?php echo $controlador->inputs->select->gt_tipo_solicitud_id; ?>
    </div>

</div>
<div class="control-group btn-alta">
    <div class="controls">
        <button type="submit" class="btn btn-success" name="guarda">Alta</button>
        <button type="submit" class="btn btn-success" name="guarda_otro">Genero Otro</button>
    </div>
</div>
