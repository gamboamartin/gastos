$(document).ready(function () {
    let btn_alta_requisitor = $("#btn-alta-requisitor");
    let btn_alta_producto = $("#btn-alta-producto");

    let sl_gt_requisitor = $("#gt_requisitor_id");
    let sl_com_producto = $("#com_producto_id");
    let sl_cat_sat_unidad = $("#cat_sat_unidad_id");

    let txt_cantidad = $("#cantidad");
    let txt_precio = $("#precio");

    let registro_id = getParameterByName('registro_id');

    var requisiciones_seleccionadas = [];
    var productos_seleccionados = [];


    var tables = $.fn.dataTable.tables(true);
    var table_gt_requisicion_producto = $(tables).DataTable().search('gt_requisicion_producto');
    table_gt_requisicion_producto.search('').columns().search('').draw();

    const table = (seccion, columns, filtros = [], extra_join = [], columnDefs = []) => {

        let $columnDefs = columnDefs.length === 0 ? [
            {
                targets: columns.length - 1,
                render: function (data, type, row, meta) {
                    let sec = getParameterByName('seccion');
                    let acc = getParameterByName('accion');
                    let registro_id = getParameterByName('registro_id');

                    let url = $(location).attr('href');
                    url = url.replace(acc, "elimina_bd");
                    url = url.replace(sec, seccion);
                    url = url.replace(registro_id, row[`${seccion}_id`]);
                    return `<button  data-url="${url}" class="btn btn-danger btn-sm">Elimina</button>`;
                }
            }
        ] : columnDefs;

        const ruta_load = get_url(seccion, "data_ajax", {ws: 1});

        return new DataTable(`#table-${seccion}`, {
            dom: 'Bfrtip',
            retrieve: true,
            ajax: {
                "url": ruta_load,
                'data': function (data) {
                    data.filtros = {
                        filtro: filtros,
                        extra_join: extra_join
                    }
                },
                "error": function (jqXHR, textStatus, errorThrown) {
                    let response = jqXHR.responseText;
                    console.log(response)
                }
            },
            columns: columns,
            columnDefs: $columnDefs
        });
    }

    const alta = (seccion, data = {}, acciones) => {
        let url = get_url(seccion, "alta_bd", {});

        $.ajax({
            url: url,
            data: data,
            type: 'POST',
            success: function (json) {
                acciones();

                if (json.hasOwnProperty("error")) {
                    alert(json.mensaje_limpio)
                }
            },
            error: function (xhr, status) {
                alert('Error, ocurrio un error al ejecutar la peticion');
                console.log({xhr, status})
            }
        });
    }

    const eliminar = (url, acciones) => {
        $.ajax({
            url: url,
            type: 'POST',
            success: function (json) {
                acciones();

                if (json.includes('error')) {
                    alert("Error al eliminar el regstro")
                }
            },
            error: function (xhr, status) {
                alert('Error, ocurrio un error al ejecutar la peticion');
                console.log({xhr, status})
            }
        });
    }

    let filtro = [{
        "key": "gt_requisicion.id",
        "valor": registro_id
    }];

    const table_gt_requisitores = table('gt_requisitores', [
        {title: "Id", data: `gt_requisitores_id`},
        {title: "Requisitor", data: 'em_empleado_nombre_completo'},
        {title: "Acciones", data: null},
    ], filtro);

    const table_gt_cotizacion_producto = table('gt_cotizacion_requisicion', [
        {title: 'Id', data: `gt_cotizacion_id`},
        {title: 'Tipo', data: `gt_tipo_cotizacion_descripcion`},
        {title: 'Proveedor', data: `gt_proveedor_descripcion`},
        {title: 'Acciones', data: null},
    ],  [
        {
            "key": "gt_cotizacion_requisicion.gt_requisicion_id",
            "valor": registro_id
        }
    ],[], [
        {
            targets: 3,
            render: function (data, type, row, meta) {
                let seccion = getParameterByName('seccion');
                let accion = getParameterByName('accion');
                let registro_id = getParameterByName('registro_id');

                let url_elimina = $(location).attr('href');
                url_elimina = url_elimina.replace(accion, "elimina_bd");
                url_elimina = url_elimina.replace(seccion, `gt_cotizacion_requisicion`);
                url_elimina = url_elimina.replace(registro_id, row[`gt_cotizacion_requisicion_id`]);

                let url_actualiza = $(location).attr('href');
                url_actualiza = url_actualiza.replace(accion, "modifica");
                url_actualiza = url_actualiza.replace(seccion, "gt_cotizacion");
                url_actualiza = url_actualiza.replace(registro_id, row[`gt_cotizacion_id`]);

                let btn_actualiza = `<a href="${url_actualiza}" class="btn btn-warning btn-sm" style="margin: 0 15px;">Actualiza</a>`
                let btn_elimina = `<button  data-url="${url_elimina}" class="btn btn-danger btn-sm">Elimina</button>`;

                return `${btn_actualiza}${btn_elimina}`;
            }
        }
    ]);

    btn_alta_requisitor.click(function () {

        let requisitor = sl_gt_requisitor.find('option:selected').val();

        if (requisitor === "") {
            alert("Seleccione un requisitor");
            return;
        }

        let data = {gt_requisitor_id: requisitor, gt_requisicion_id: registro_id};

        alta("gt_requisitores", data, () => {
            sl_gt_requisitor.val('').change();
            $('#table-gt_requisitores').DataTable().clear().destroy();
            table('gt_requisitores', [
                {title: "Id", data: `gt_requisitores_id`},
                {title: "Requisitor", data: 'em_empleado_nombre_completo'},
                {title: "Acciones", data: null},
            ], filtro);
        });
    });

    btn_alta_producto.click(function () {

        let producto = sl_com_producto.find('option:selected').val();
        let unidad = sl_cat_sat_unidad.find('option:selected').val();
        let cantidad = txt_cantidad.val();
        let precio = txt_precio.val();

        if (producto === "") {
            alert("Seleccione un producto");
            return;
        }

        if (unidad === "") {
            alert("Seleccione una unidad");
            return;
        }

        if (cantidad === "") {
            alert("Ingrese una cantidad");
            return;
        }

        if (precio === "") {
            alert("Ingrese un precio");
            return;
        }

        let url = get_url("gt_requisicion_producto", "alta_bd", {});

        $.ajax({
            url: url,
            data: {
                com_producto_id: producto,
                cat_sat_unidad_id: unidad,
                cantidad: cantidad,
                precio: precio,
                gt_requisicion_id: registro_id
            },
            type: 'POST',
            success: function (json) {
                sl_com_producto.val('').change();
                sl_cat_sat_unidad.val('').change();
                txt_cantidad.val('');
                txt_precio.val('');

                if (json.hasOwnProperty("error")) {
                    alert(json.mensaje_limpio)
                    return;
                }

                table_gt_requisicion_producto.ajax.reload();
            },
            error: function (xhr, status) {
                alert('Error, ocurrio un error al ejecutar la peticion');
                console.log({xhr, status})
            }
        });
    });

    table_gt_requisitores.on('click', 'button', function (e) {
        const url = $(this).data("url");

        $.ajax({
            url: url,
            type: 'POST',
            success: function (json) {
                $('#table-requisitor').DataTable().clear().destroy();


                if (json.includes('error')) {
                    alert("Error al eliminar el regstro")
                }
            },
            error: function (xhr, status) {
                alert('Error, ocurrio un error al ejecutar la peticion');
                console.log({xhr, status})
            }
        });
    });
    table_gt_cotizacion_producto.on('click', 'button', function (e) {
        const url = $(this).data("url");

        $.ajax({
            url: url,
            type: 'POST',
            success: function (json) {
                if (json.includes('error')) {
                    alert("Error al eliminar el regstro")
                    return;
                }

                $('#table-productos').DataTable().clear().destroy();
                main_productos('gt_solicitud_producto', 'productos');
            },
            error: function (xhr, status) {
                alert('Error, ocurrio un error al ejecutar la peticion');
                console.log({xhr, status})
            }
        });
    });


    seleccionar_tabla('#gt_requisicion_producto', table_gt_requisicion_producto, '#agregar_producto', function (seleccionados) {
        alta_productos('#form-cotizacion', seleccionados);
    });

});













