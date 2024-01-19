$(document).ready(function () {

    let btn_alta_autorizante = $("#btn-alta-autorizante");
    let btn_alta_solicitante = $("#btn-alta-solicitante");
    let btn_alta_producto = $("#btn-alta-producto");

    let sl_gt_autorizante = $("#gt_autorizante_id");
    let sl_gt_soliciante = $("#gt_solicitante_id");

    let sl_com_producto = $("#com_producto_id");
    let sl_cat_sat_unidad = $("#cat_sat_unidad_id");

    let txt_cantidad = $("#cantidad");
    let txt_precio = $("#precio");

    let registro_id = getParameterByName('registro_id');

    var productos_seleccionados = [];

    var tables = $.fn.dataTable.tables(true);
    var table_gt_solicitud_producto = $(tables).DataTable().search('gt_solicitud_producto');
    table_gt_solicitud_producto.search('').columns().search('').draw();

    const table = (seccion, columns, filtro = [], extra_join = []) => {
        const ruta_load = get_url(seccion, "data_ajax", {ws: 1});

        return new DataTable(`#table-${seccion}`, {
            dom: 'Bfrtip',
            retrieve: true,
            ajax: {
                "url": ruta_load,
                'data': function (data) {
                    data.filtros = {
                        filtro: filtro,
                        extra_join: extra_join
                    }
                },
                "error": function (jqXHR, textStatus, errorThrown) {
                    let response = jqXHR.responseText;
                    console.log(response)
                }
            },
            columns: columns,
            columnDefs: [
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
            ]
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
        "key": "gt_solicitud.id",
        "valor": registro_id
    }];

    const table_gt_autorizantes = table('gt_autorizantes', [
        {title: "Id", data: `gt_autorizantes_id`},
        {title: "Autorizante", data: 'em_empleado_nombre_completo'},
        {title: "Acciones", data: null},
    ], filtro);
    const table_gt_solicitantes = table('gt_solicitantes', [
        {title: "Id", data: `gt_solicitantes_id`},
        {title: "Solicitante", data: 'em_empleado_nombre_completo'},
        {title: "Acciones", data: null},
    ], filtro);
    const table_gt_requisicion_producto = table('gt_requisicion_producto', [
        {title: 'Id', data: `gt_requisicion_producto_id`},
        {title: 'Tipo', data: `gt_tipo_requisicion_descripcion`},
        {title: 'Producto', data: `com_producto_descripcion`},
        {title: 'Unidad', data: `cat_sat_unidad_descripcion`},
        {title: 'Cantidad', data: `gt_requisicion_producto_cantidad`},
        {title: 'Precio', data: `gt_requisicion_producto_precio`},
        {title: 'Total', data: `gt_requisicion_producto_total`},
        {title: 'Acciones', data: null},
    ], [], [{
        "entidad": "gt_solicitud_requisicion",
        "key": "gt_solicitud_id",
        "enlace": "gt_requisicion",
        "key_enlace": "id",
        "renombre": "gt_solicitud_requisicion"
    }]);


    btn_alta_autorizante.click(function () {

        let autorizante = sl_gt_autorizante.find('option:selected').val();

        if (autorizante === "") {
            alert("Seleccione un autorizante");
            return;
        }

        let data = {gt_autorizante_id: autorizante, gt_solicitud_id: registro_id};

        alta("gt_autorizantes", data, () => {
            sl_gt_autorizante.val('').change();
            $('#table-gt_autorizantes').DataTable().clear().destroy();
            table('gt_autorizantes', [
                {title: "Id", data: `gt_autorizantes_id`},
                {title: "Autorizante", data: 'em_empleado_nombre_completo'},
                {title: "Acciones", data: null},
            ], filtro);
        });
    });

    btn_alta_solicitante.click(function () {

        let solicitante = sl_gt_soliciante.find('option:selected').val();

        if (solicitante === "") {
            alert("Seleccione un solicitante");
            return;
        }

        let data = {gt_solicitante_id: solicitante, gt_solicitud_id: registro_id};

        alta("gt_solicitantes", data, () => {
            sl_gt_soliciante.val('').change();
            $('#table-gt_solicitantes').DataTable().clear().destroy();
            table('gt_solicitantes', [
                {title: "Id", data: `gt_solicitantes_id`},
                {title: "Solicitante", data: 'em_empleado_nombre_completo'},
                {title: "Acciones", data: null},
            ], filtro);
        });
    });

    table_gt_autorizantes.on('click', 'button', function (e) {
        const url = $(this).data("url");

        eliminar(url, () => {
            $('#table-gt_autorizantes').DataTable().clear().destroy();
            table('gt_autorizantes', [
                {title: "Id", data: `gt_autorizantes_id`},
                {title: "Autorizante", data: 'em_empleado_nombre_completo'},
                {title: "Acciones", data: null},
            ], filtro);
        })
    });

    table_gt_solicitantes.on('click', 'button', function (e) {
        const url = $(this).data("url");

        eliminar(url, () => {
            $('#table-gt_solicitantes').DataTable().clear().destroy();
            table('gt_solicitantes', [
                {title: "Id", data: `gt_solicitantes_id`},
                {title: "Solicitante", data: 'em_empleado_nombre_completo'},
                {title: "Acciones", data: null},
            ], filtro);
        })
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

        let url = get_url("gt_solicitud_producto", "alta_bd", {});

        $.ajax({
            url: url,
            data: {
                com_producto_id: producto,
                cat_sat_unidad_id: unidad,
                cantidad: cantidad,
                precio: precio,
                gt_solicitud_id: registro_id
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

                $('#table-productos').DataTable().clear().destroy();
                main_productos('gt_solicitud_producto', 'productos');
            },
            error: function (xhr, status) {
                alert('Error, ocurrio un error al ejecutar la peticion');
                console.log({xhr, status})
            }
        });
    });


    table_gt_requisicion_producto.on('click', 'button', function (e) {
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

    let getData = async (url, acciones) => {
        fetch(url)
            .then(response => response.json())
            .then(data => acciones(data))
            .catch(err => {
                alert('Error al ejecutar');
                console.error("ERROR: ", err.message)
            });
    }

    sl_com_producto.change(function () {
        let selected = $(this).find('option:selected');

        let url = get_url("gt_solicitud_producto", "get_precio_promedio", {com_producto_id: selected.val()}, 0);

        getData(url, (data) => {
            txt_precio.val('');

            if (data.n_registros > 0) {
                let total = 0.0;
                $.each(data.registros, function (index, registro) {
                    total += parseFloat(registro.gt_solicitud_producto_precio);
                });

                let promedio = total / data.n_registros;
                txt_precio.val(promedio.toFixed(3));
            }
        });

    });

    let timer = null;

    $('#gt_solicitud_producto').on('click', 'thead:first-child, tbody', function (event) {

        if (timer) {
            clearTimeout(timer);
        }

        timer = setTimeout(() => {
            var selectedData = table_gt_solicitud_producto.rows('.selected').data();

            productos_seleccionados = [];

            selectedData.each(function (value, row, data) {
                productos_seleccionados.push(value.com_producto_id);
            });

            $('#agregar_producto').val(productos_seleccionados);
        }, 500);
    });

    $('#form-orden').on('submit', function (e) {
        if (productos_seleccionados.length === 0) {
            e.preventDefault();
            alert("Seleccione un producto");
        }
    });


});





