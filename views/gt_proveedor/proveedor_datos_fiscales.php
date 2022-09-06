<?php /** @var base\controller\controlador_base $controlador  viene de registros del controler/lista */ ?>

<?php
use config\generales;
use config\views;
?>
<form method="post" action="./index.php?seccion=gt_proveedor&accion=modifica_bd&session_id=<?php echo $controlador->session_id; ?>&registro_id=<?php echo $controlador->registro_id; ?>" class="form-additional">
<div class="row form-group">
    <div class="col-md-12 mb-3 mb-md-0">
        <h3>Datos Fiscales</h3>

    </div>
</div>



<div class="control-group col-sm-6">
    <label class="control-label" for="rfc">RFC</label>
    <div class="controls">
        <input type="text" name="rfc" value="<?php echo $controlador->row_upd->rfc; ?>" class="form-control" required="" id="rfc" placeholder="RFC">
    </div>
</div>
    <div class="control-group col-sm-6">
        <label class="control-label" for="razon_social">Razon social</label>
        <div class="controls">
            <input type="text" name="razon_social" value="<?php echo $controlador->row_upd->razon_social; ?>" class="form-control" required="" id="razon_social" placeholder="Razon Social">
        </div>
    </div>
    <?php echo $controlador->inputs->select->cat_sat_regimen_fiscal_id; ?>

    <?php echo $controlador->inputs->select->dp_calle_pertenece_id; ?>

<div class="control-group col-sm-6">
    <label class="control-label" for="exterior">Exterior</label>
    <div class="controls">
        <input type="text" name="exterior" value="<?php echo $controlador->row_upd->exterior; ?>" class="form-control" required="" id="exterior" placeholder="Exterior">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="interior">Interior</label>
    <div class="controls">
        <input type="text" name="interior" value="<?php echo $controlador->row_upd->interior; ?>" class="form-control" required="" id="interior" placeholder="Interior">
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
        <input type="text" name="contacto_1" value="<?php echo $controlador->row_upd->contacto_1; ?>" class="form-control" required="" id="contacto_1" placeholder="Contacto 1">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="telefono_1">Telefono 1</label>
    <div class="controls">
        <input type="text" name="telefono_1" value="<?php echo $controlador->row_upd->telefono_1; ?>" class="form-control" required="" id="telefono_1" placeholder="Telefono 1">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="contacto_2">Contacto 2</label>
    <div class="controls">
        <input type="text" name="contacto_2" value="<?php echo $controlador->row_upd->contacto_2; ?>" class="form-control" required="" id="contacto_2" placeholder="Contacto 2">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="telefono_2">Telefono 2</label>
    <div class="controls">
        <input type="text" name="telefono_2" value="<?php echo $controlador->row_upd->telefono_2; ?>" class="form-control" required="" id="telefono_2" placeholder="Telefono 2">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="contacto_3">Contacto 3</label>
    <div class="controls">
        <input type="text" name="contacto_3" value="<?php echo $controlador->row_upd->contacto_3; ?>" class="form-control" required="" id="contacto_3" placeholder="Contacto 3">
    </div>
</div>
<div class="control-group col-sm-6">
    <label class="control-label" for="telefono_3">Telefono 3</label>
    <div class="controls">
        <input type="text" name="telefono_3" value="<?php echo $controlador->row_upd->telefono_1; ?>" class="form-control" required="" id="telefono_3" placeholder="Telefono 3">
    </div>
</div>
    <?php include (new views())->ruta_templates.'botons/submit/modifica_bd.php';?>
</form>

