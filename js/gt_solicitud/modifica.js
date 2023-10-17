let btn_alta_autorizante = $("#btn-alta-autorizante");
let btn_alta_solicitante = $("#btn-alta-solicitante");

let sl_em_empleado1 = $(".autorizantes #em_empleado_id");
let sl_em_empleado2 = $(".solicitantes #em_empleado_id");

btn_alta_autorizante.click(function () {

    let selected_empleado = sl_em_empleado1.find('option:selected').val();

    if (selected_empleado === "") {
        alert("Seleccione un empleado");
        return;
    }

    let url = get_url("gt_autorizante", "alta_bd", {});

    $.ajax({
        url: url,
        data: {em_empleado_id: selected_empleado},
        type: 'POST',
        success: function (json) {
            sl_em_empleado1.val('').change();
            $('#table-autorizante').DataTable().clear().destroy();
            main('gt_autorizante', 'autorizante');
        },
        error: function (xhr, status) {
            alert('Error, ocurrio un error al ejecutar la peticion');
            console.log({xhr, status})
        }
    });
});

btn_alta_solicitante.click(function () {

    let selected_empleado = sl_em_empleado2.find('option:selected').val();

    if (selected_empleado === "") {
        alert("Seleccione un empleado");
        return;
    }

    let url = get_url("gt_solicitante", "alta_bd", {});

    $.ajax({
        url: url,
        data: {em_empleado_id: selected_empleado},
        type: 'POST',
        success: function (json) {
            sl_em_empleado2.val('').change();
            $('#table-solicitante').DataTable().clear().destroy();
            main('gt_solicitante', 'solicitante');
        },
        error: function (xhr, status) {
            alert('Error, ocurrio un error al ejecutar la peticion');
            console.log({xhr, status})
        }
    });
});

const main = (seccion, identificador) => {
    const ruta_load = get_url(seccion, "get_data", {ws: 1});

    let table = new DataTable(`#table-${identificador}`, {
        dom: 'Bfrtip',
        retrieve: true,
        ajax: {
            "url": ruta_load,
            "error": function (jqXHR, textStatus, errorThrown) {
                let response = jqXHR.responseText;
                console.log(response)
            }
        },
        columns: [
            {title: 'Id', data: `gt_${identificador}_id`},
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
                    url = url.replace(seccion, `gt_${identificador}`);
                    url = url.replace(registro_id, row[`gt_${identificador}_id`]);
                    return `<a href="${url}" class="btn btn-danger btn-sm">Elimina</a>`;
                }
            }
        ]
    });
}

main('gt_autorizante', 'autorizante');
main('gt_solicitante', 'solicitante');

