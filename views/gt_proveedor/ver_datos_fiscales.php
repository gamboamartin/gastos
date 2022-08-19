<?php use config\views; ?>
<?php /** @var \gamboamartin\gastos\controllers\controlador_gt_proveedor $controlador */ ?>
<?php /** @var stdClass $row  viene de registros del controler*/ ?>
<?php include("contact.php");?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
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
                                <th scope="col">Modifica</th>
                                <th scope="col">Contactos</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?php echo $controlador->row_upd->gt_proveedor_rfc?></td>
                                <td><?php echo $controlador->row_upd->gt_proveedor_cat_sat_regimen_fiscal_id?></td>
                                <td><?php echo $controlador->row_upd->gt_proveedor_dp_calle_pertenece_id?></td>
                                <td><?php echo $controlador->row_upd->gt_proveedor_exterior?></td>
                                <td><?php echo $controlador->row_upd->gt_proveedor_interior?></td>
                                <td><?php echo $controlador->row_upd->gt_proveedor_pagina_web?></td>
                                <td>
                                    <a href="./index.php?seccion=wt_hogar&accion=detalles_ubicacion&registro_id=<?php echo $controlador->registro_id; ?>&session_id=<?php echo $controlador->session_id; ?>" class="btn btn-info"><i class="glyphicon glyphicon-edit"></i>
                                        Modificar
                                    </a>
                                </td>
                                <td>
                                    <a >
                                        <button type="button" class="btn btn-default" style="color: cadetblue" data-toggle="modal" data-target="#dataInfo"><i class='glyphicon glyphicon-user' ></i>
                                        Informacion</button>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script src="js/app.js"></script>
<script>
    $(document).ready(function(){
        load(1);
    });
</script>