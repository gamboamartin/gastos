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

    const table = (seccion, columns, filtro = []) => {
        const ruta_load = get_url(seccion, "data_ajax", {ws: 1});

        return new DataTable(`#table-${seccion}`, {
            dom: 'Bfrtip',
            retrieve: true,
            ajax: {
                "url": ruta_load,
                'data': function (data) {
                    data.filtros = {
                        filtro: filtro
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

    const eliminar = (acciones) => {
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

    btn_alta_autorizante.click(function () {

        let autorizante = sl_gt_autorizante.find('option:selected').val();

        if (autorizante === "") {
            alert("Seleccione un autorizante");
            return;
        }

        let data = {gt_autorizante_id: autorizante, gt_solicitud_id: registro_id};

        alta("gt_autorizantes", data, () => {
            sl_gt_autorizante.val('').change();
            table_gt_autorizantes.clear().destroy();
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

        let url = get_url("gt_solicitantes", "alta_bd", {});

        $.ajax({
            url: url,
            data: {gt_solicitante_id: solicitante, gt_solicitud_id: registro_id},
            type: 'POST',
            success: function (json) {
                sl_gt_soliciante.val('').change();
                $('#table-gt_solicitantes').DataTable().clear().destroy();
                table('gt_solicitantes', [
                    {title: "Id", data: `gt_solicitantes_id`},
                    {title: "Solicitante", data: 'em_empleado_nombre_completo'},
                    {title: "Acciones", data: null},
                ], filtro);

                if (json.hasOwnProperty("error")) {
                    alert(json.mensaje_limpio)
                }
            },
            error: function (xhr, status) {
                alert('Error, ocurrio un error al ejecutar la peticion');
                console.log({xhr, status})
            }
        });
    });

    table_gt_autorizantes.on('click', 'button', function (e) {
        const url = $(this).data("url");

        eliminar(() => {
            table_gt_autorizantes.clear().destroy();
            table('gt_autorizantes', [
                {title: "Id", data: `gt_autorizantes_id`},
                {title: "Autorizante", data: 'em_empleado_nombre_completo'},
                {title: "Acciones", data: null},
            ], filtro);
        })
    });

    table_gt_solicitantes.on('click', 'button', function (e) {
        const url = $(this).data("url");

        eliminar(() => {
            table_gt_solicitantes.clear().destroy();
            table('gt_solicitantes', [
                {title: "Id", data: `gt_solicitantes_id`},
                {title: "Solicitante", data: 'em_empleado_nombre_completo'},
                {title: "Acciones", data: null},
            ], filtro);
        })
    });


});





