<?php /** @var base\controller\controlador_base $controlador  viene de registros del controler/lista */ ?>

<?php
use config\generales;
use config\views;
use models\gt_autorizante;
use models\gt_autorizantes;
use models\gt_solicitantes;

$gt_solicitantes = new gt_solicitantes($controlador->link);

$gt_autorizantes = new gt_autorizantes($controlador->link);

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


<div class="widget  widget-box box-container form-main widget-form-cart" id="form">
        <div class="row">
            <div class="col-md-12">

                <div class="widget widget-box box-container widget-mylistings">
                    <h2>Solicitantes</h2>
                    <div class="">
                        <table class="table table-striped footable-sort" data-sorting="true">
                            <th>Id</th>
                            <th>Codigo</th>
                            <th>Codigo Bis</th>
                            <th>Descripcion</th>
                            <th>Fecha asignacion</th>

                            <th>Modifica</th>
                            <th>Elimina</th>

                            <tbody>
                            <script>
                                let id_solicitantes = Array();
                            </script>
                            <?php
                            $gt_solicitantes_buscados['gt_solicitud_id'] = $controlador->registro_id;
                            $gt_solicitantes->registros();
                            $r_gt_autorizantes = $gt_solicitantes->filtro_and(filtro: $gt_solicitantes_buscados);
                            foreach ($gt_solicitantes->registros as $solicitantes){
                                ?>
                                <tr>
                                    <td><?php echo $solicitantes['gt_solicitantes_id']; ?></td>
                                    <td><?php echo $solicitantes['gt_solicitantes_codigo']; ?></td>
                                    <td><?php echo $solicitantes['gt_solicitantes_codigo_bis']; ?></td>
                                    <td><?php echo $solicitantes['gt_solicitantes_descripcion']; ?></td>
                                    <td><?php echo $solicitantes['gt_solicitantes_fecha_alta']; ?></td>
                                    <script>
                                        id_solicitantes.push(<?php echo $solicitantes['gt_solicitantes_gt_solicitante_id']; ?>);
                                    </script>
                                    <td><a href="./index.php?seccion=gt_solicitantes&accion=modifica&registro_id=<?php echo $solicitantes['gt_solicitantes_id']; ?>&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info">
                                            Modificar
                                        </a>
                                    </td>
                                    <td><a href="./index.php?seccion=gt_solicitantes&accion=elimina_bd&registro_id=<?php echo $solicitantes['gt_solicitantes_id']; ?>&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-danger">
                                            Eliminar
                                        </a>
                                    </td>


                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="box-body">
                            * Total registros: <?php echo $gt_solicitantes->n_registros; ?><br />
                            * Fecha Hora: <?php echo $controlador->fecha_hoy; ?>
                        </div>
                    </div>
                </div> <!-- /. widget-table-->
            </div><!-- /.center-content -->
        </div>

    <div class="row">
        <div class="col-md-12">

            <div class="widget widget-box box-container widget-mylistings">
                <h2>Autorizantes</h2>

                <div class="">
                    <table class="table table-striped footable-sort" data-sorting="true">
                        <th>Id</th>
                        <th>Codigo</th>
                        <th>Codigo Bis</th>
                        <th>Descripcion</th>
                        <th>Fecha asignacion</th>

                        <th>Modifica</th>
                        <th>Elimina</th>

                        <tbody>
                        <script>
                            let id_autorizantes = Array();
                        </script>
                        <?php
                        $gt_autorizantes_buscados['gt_solicitud_id'] = $controlador->registro_id;
                        $gt_autorizantes->registros();
                        $r_gt_autorizantes = $gt_autorizantes->filtro_and(filtro: $gt_autorizantes_buscados);
                        foreach ($gt_autorizantes->registros as $autorizante){
                            ?>
                            <tr>
                                <td><?php echo $autorizante['gt_autorizantes_id']; ?></td>
                                <td><?php echo $autorizante['gt_autorizantes_codigo']; ?></td>
                                <td><?php echo $autorizante['gt_autorizantes_codigo_bis']; ?></td>
                                <td><?php echo $autorizante['gt_autorizantes_descripcion']; ?></td>
                                <td><?php echo $autorizante['gt_autorizantes_fecha_alta']; ?></td>
                                <script>
                                    id_autorizantes.push(<?php echo $autorizante['gt_autorizantes_gt_autorizante_id']; ?>);
                                </script>
                                <td><a href="./index.php?seccion=gt_autorizantes&accion=modifica&registro_id=<?php echo $autorizante['gt_autorizantes_id']; ?>&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info">
                                        Modificar
                                    </a>
                                </td>
                                <td><a href="./index.php?seccion=gt_autorizantes&accion=elimina_bd&registro_id=<?php echo $autorizante['gt_autorizantes_id']; ?>&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-danger">
                                        Eliminar
                                    </a>
                                </td>


                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div class="box-body">
                        * Total registros: <?php echo $gt_autorizantes->n_registros; ?><br />
                        * Fecha Hora: <?php echo $controlador->fecha_hoy; ?>
                    </div>
                </div>
            </div> <!-- /. widget-table-->
        </div><!-- /.center-content -->
    </div>
    </div>
</div>
