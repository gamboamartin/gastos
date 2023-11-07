let btn_alta_autorizante = $("#btn-alta-autorizante");
let btn_alta_solicitante = $("#btn-alta-solicitante");

let sl_gt_autorizante = $("#gt_autorizante_id");
let sl_gt_soliciante = $("#gt_solicitante_id");

let registro_id = getParameterByName('registro_id');

btn_alta_autorizante.click(function () {

    let autorizante = sl_gt_autorizante.find('option:selected').val();

    if (autorizante === "") {
        alert("Seleccione un autorizante");
        return;
    }

    let url = get_url("gt_autorizantes", "alta_bd", {});

    $.ajax({
        url: url,
        data: {gt_autorizante_id: autorizante, gt_solicitud_id: registro_id},
        type: 'POST',
        success: function (json) {
            sl_gt_autorizante.val('').change();
            $('#table-autorizante').DataTable().clear().destroy();
            main('gt_autorizantes', 'autorizante');

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
            $('#table-solicitante').DataTable().clear().destroy();
            main('gt_solicitantes', 'solicitante');

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

const main = (seccion, identificador) => {
    const ruta_load = get_url(seccion, "data_ajax", {ws: 1});


    let table = new DataTable(`#table-${identificador}`, {
        dom: 'Bfrtip',
        retrieve: true,
        ajax: {
            "url": ruta_load,
            'data': function (data) {
                data.filtros = {
                    filtro: [{
                        "key": "gt_solicitud.id",
                        "valor": registro_id
                    }]
                }
            },
            "error": function (jqXHR, textStatus, errorThrown) {
                let response = jqXHR.responseText;
                console.log(response)
            }
        },
        columns: [
            {title: 'Id', data: `gt_${identificador}s_id`},
            {title: identificador, data: 'em_empleado_nombre'},
            {title: 'Acciones', data: null},
        ],
        columnDefs: [
            {
                targets: 1,
                render: function (data, type, row, meta) {
                    return `${row.em_empleado_ap} ${row.em_empleado_am} ${row.em_empleado_nombre}`;
                }
            },
            {
                targets: 2,
                render: function (data, type, row, meta) {
                    let seccion = getParameterByName('seccion');
                    let accion = getParameterByName('accion');
                    let registro_id = getParameterByName('registro_id');

                    let url = $(location).attr('href');
                    url = url.replace(accion, "elimina_bd");
                    url = url.replace(seccion, `gt_${identificador}s`);
                    url = url.replace(registro_id, row[`gt_${identificador}s_id`]);
                    return `<button  data-url="${url}" class="btn btn-danger btn-sm">Elimina</button>`;
                }
            }
        ]
    });

    return table;
}

const table_1 = main('gt_autorizantes', 'autorizante');
const table_2 = main('gt_solicitantes', 'solicitante');

table_1.on('click', 'button', function (e) {
    const url = $(this).data("url");

    $.ajax({
        url: url,
        type: 'POST',
        success: function (json) {
            $('#table-autorizante').DataTable().clear().destroy();
            main('gt_autorizantes', 'autorizante');

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

table_2.on('click', 'button', function (e) {
    const url = $(this).data("url");

    $.ajax({
        url: url,
        type: 'POST',
        success: function (json) {
            $('#table-solicitante').DataTable().clear().destroy();
            main('gt_solicitantes', 'solicitante');

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




