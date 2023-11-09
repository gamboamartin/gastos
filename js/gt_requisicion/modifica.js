let btn_alta_requisitor = $("#btn-alta-requisitor");

let sl_gt_requisitor = $("#gt_requisitor_id");

let registro_id = getParameterByName('registro_id');

btn_alta_requisitor.click(function () {

    let requisitor = sl_gt_requisitor.find('option:selected').val();

    if (requisitor === "") {
        alert("Seleccione un requisitor");
        return;
    }

    let url = get_url("gt_requisitores", "alta_bd", {});

    $.ajax({
        url: url,
        data: {gt_requisitor_id: requisitor, gt_requisicion_id: registro_id},
        type: 'POST',
        success: function (json) {
            sl_gt_requisitor.val('').change();
            $('#table-requisitor').DataTable().clear().destroy();
            main('gt_requisitores', 'requisitor');

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
                        "key": "gt_requisicion.id",
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

const table_1 = main('gt_requisitores', 'requisitor');

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






