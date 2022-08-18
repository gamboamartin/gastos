<?php /** @var base\controller\controlador_base $controlador  viene de registros del controler/lista */ ?>

<div class="control-group col-sm-6">
    <label class="control-label" for="descripcion">Descripcion</label>
    <div class="controls">
        <input type="text" name="descripcion" value="" class="form-control" required="" id="descripcion" placeholder="Descripcion">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="descripcion_select">Descripcion Select</label>
    <div class="controls">
        <input type="text" name="descripcion_select" value="" class="form-control" required="" id="descripcion_select" placeholder="Descripcion Select">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="codigo">Codigo</label>
    <div class="controls">
        <input type="text" name="codigo" value="" class="form-control" required="" id="codigo" placeholder="Codigo">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="observaciones">Observaciones</label>
    <div class="controls">
        <input type="text" name="observaciones" value="" class="form-control" required="" id="observaciones" placeholder="Observaciones">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="url">Url</label>
    <div class="controls">
        <input type="text" name="url" value="" class="form-control" required="" id="Url" placeholder="Url">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="img_descripcion">Img Descripcion</label>
    <div class="controls">
        <input type="text" name="img_descripcion" value="" class="form-control" required="" id="img_descripcion" placeholder="img_descripcion">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="georeferencia">Georeferencia</label>
    <div class="controls">
        <input type="text" name="georeferencia" value="" class="form-control" required="" id="georeferencia" placeholder="Georeferencia">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="ubicacion">Ubicacion</label>
    <div class="controls">
        <input type="text" name="ubicacion" value="" class="form-control" required="" id="ubicacion" placeholder="Ubicacion">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="wt_proposito">Proposito</label>
    <div class="controls">
        <?php echo $controlador->inputs->select->wt_proposito_id; ?>
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="tipo_inmueble">Tipo Inmueble</label>
    <div class="controls">
        <?php echo $controlador->inputs->select->wt_tipo_inmueble_id; ?>
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="terreno">Terreno</label>
    <div class="controls">
        <input type="text" name="terreno" value="" class="form-control" required="" id="terreno" placeholder="Terreno">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="construccion">Construccion</label>
    <div class="controls">
        <input type="text" name="construccion" value="" class="form-control" required="" id="construccion" placeholder="Construccion">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="niveles">Niveles</label>
    <div class="controls">
        <input type="text" name="niveles" value="" class="form-control" required="" id="niveles" placeholder="Niveles">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="banio">Baños</label>
    <div class="controls">
        <input type="text" name="banio" value="" class="form-control" required="" id="banio" placeholder="Baños">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="recamara">Recamaras</label>
    <div class="controls">
        <input type="text" name="recamara" value="" class="form-control" required="" id="recamara" placeholder="Recamara">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="patio">Patio</label>
    <div class="controls">
        <input type="text" name="patio" value="" class="form-control" required="" id="patio" placeholder="Patio">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="estacionamiento">Estacionamiento</label>
    <div class="controls">
        <input type="text" name="estacionamiento" value="" class="form-control" required="" id="estacionamiento" placeholder="Estacionamiento">
    </div>
</div>
<div class="control-group btn-alta">
    <div class="controls">
        <button type="submit" class="btn btn-success" name="guarda">Alta</button>
        <button type="submit" class="btn btn-success" name="guarda_otro">Genero Otro</button>
    </div>
</div>
