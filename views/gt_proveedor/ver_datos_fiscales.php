<?php use config\views; ?>
<?php /** @var \gamboamartin\gastos\controllers\controlador_gt_proveedor $controlador */ ?>
<?php /** @var stdClass $row  viene de registros del controler*/ ?>
<div class="widget  widget-box box-container form-main widget-form-cart" id="form">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <section class="top-title">
                    <ul class="breadcrumb">
                        <li class="item"><a href="./index.php?seccion=adm_session&accion=inicio&session_id=<?php echo $controlador->session_id; ?>"> Inicio </a></li>
                        <li class="item"><a href="./index.php?seccion=gt_proveedor&accion=lista&session_id=<?php echo $controlador->session_id; ?>"> Lista </a></li>
                        <li class="item"> <?php echo $controlador->row_upd->gt_proveedor_descripcion?> </li>
                    </ul>    <h1 class="h-side-title page-title page-title-big text-color-primary"><?php echo strtoupper($controlador->row_upd->gt_proveedor_descripcion)?></h1>
                </section> <!-- /. content-header -->
                <div class="widget  widget-box box-container form-main widget-form-cart" id="form">
                    <div class="widget-header">
                        <h2>Datos Fiscales</h2>
                    </div>
                    <div>
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">RFC</th>
                                <th scope="col">Regimen Fiscal</th>
                                <th scope="col">Calle</th>
                                <th scope="col">Exterior</th>
                                <th scope="col">Interior</th>
                                <th scope="col">Pagina Web</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?php echo $controlador->row_upd->gt_proveedor_rfc?></td>
                                <td><?php echo $controlador->row_upd->gt_proveedor_cat_sat_regimen_fiscal_id?></td>
                                <td><?php echo $controlador->row_upd->gt_proveedor_dp_calle_pertenece_id?></td>
                                <td><?php echo $controlador->row_upd->gt_proveedor_exterior?></td>
                                <td><?php echo $controlador->row_upd->gt_proveedor_interior?></td>
                                <td>
                                    <a href="./index.php?seccion=wt_hogar&accion=detalles_ubicacion&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i>
                                        Modificar
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Telefono</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?php echo $controlador->row_upd->gt_proveedor_contacto_1?></td>
                                <td><?php echo $controlador->row_upd->gt_proveedor_telefono_1?></td>
                                <td>
                                    <a href="./index.php?seccion=wt_hogar&accion=detalles_ubicacion&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i>
                                        Modificar
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $controlador->row_upd->gt_proveedor_contacto_2?></td>
                                <td><?php echo $controlador->row_upd->gt_proveedor_telefono_2?></td>
                                <td>
                                    <a href="./index.php?seccion=wt_hogar&accion=detalles_ubicacion&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i>
                                        Modificar
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $controlador->row_upd->gt_proveedor_contacto_3?></td>
                                <td><?php echo $controlador->row_upd->gt_proveedor_telefono_3?></td>
                                <td>
                                    <a href="./index.php?seccion=wt_hogar&accion=detalles_ubicacion&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i>
                                        Modificar
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.center-content -->
        </div>
    </div>

</div>