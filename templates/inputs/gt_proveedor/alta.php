<?php /** @var base\controller\controlador_base $controlador  viene de registros del controler/lista */ ?>


<div class="row form-group">
    <div class="col-md-12 mb-3 mb-md-0">
        <h3>Generales</h3>

    </div>
</div>
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
    <label class="control-label" for="pagina_web">Pagina Web</label>
    <div class="controls">
        <input type="text" name="pagina_web" value="" class="form-control" required="" id="pagina_web" placeholder="Pagina Web">
    </div>
</div>
<div class="control-group col-md-6">
    <label class="control-label" for="gt_tipo_proveedor">Tipo proveedor</label>
    <?php echo $controlador->inputs->select->gt_tipo_proveedor_id; ?>
</div>
<div class="row form-group">
    <div class="col-md-12 mb-3 mb-md-0">
        <h3>Datos Fiscales</h3>

    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="rfc">RFC</label>
    <div class="controls">
        <input type="text" name="rfc" value="" class="form-control" required="" id="rfc" placeholder="RFC">
    </div>
</div>
<div class="control-group col-md-6">
    <label class="control-label" for="cat_sat_regimen_fiscal">Regimen Fiscal</label>
    <?php echo $controlador->inputs->select->cat_sat_regimen_fiscal_id; ?>
</div>
<div class="control-group col-md-6">
    <label class="control-label" for="dp_calle_pertenece">Calle</label>
    <?php echo $controlador->inputs->select->dp_calle_pertenece_id; ?>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="exterior">Exterior</label>
    <div class="controls">
        <input type="text" name="exterior" value="" class="form-control" required="" id="exterior" placeholder="Exterior">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="interior">Interior</label>
    <div class="controls">
        <input type="text" name="interior" value="" class="form-control" required="" id="interior" placeholder="Interior">
    </div>
</div>
<div class="row form-group">
    <div class="col-md-12 mb-3 mb-md-0">
        <h3>Contacto</h3>

    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="contacto_1">Contacto 1</label>
    <div class="controls">
        <input type="text" name="contacto_1" value="" class="form-control" required="" id="contacto_1" placeholder="Contacto 1">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="telefono_1">Telefono 1</label>
    <div class="controls">
        <input type="text" name="telefono_1" value="" class="form-control" required="" id="telefono_1" placeholder="Telefono 1">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="contacto_2">Contacto 2</label>
    <div class="controls">
        <input type="text" name="contacto_2" value="" class="form-control" required="" id="contacto_2" placeholder="Contacto 2">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="telefono_2">Telefono 2</label>
    <div class="controls">
        <input type="text" name="telefono_2" value="" class="form-control" required="" id="telefono_2" placeholder="Telefono 2">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="contacto_3">Contacto 3</label>
    <div class="controls">
        <input type="text" name="contacto_3" value="" class="form-control" required="" id="contacto_3" placeholder="Contacto 3">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="telefono_3">Telefono 3</label>
    <div class="controls">
        <input type="text" name="telefono_3" value="" class="form-control" required="" id="telefono_3" placeholder="Telefono 3">
    </div>
</div>
<div class="control-group btn-alta">
    <div class="controls">
        <button type="submit" class="btn btn-success" name="guarda">Alta</button>
        <button type="submit" class="btn btn-success" name="guarda_otro">Genero Otro</button>
    </div>
</div>
