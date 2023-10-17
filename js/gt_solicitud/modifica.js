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

    let url = get_url("gt_autorizante","alta_bd", {});

    $.ajax({
        url : url,
        data : {em_empleado_id: selected_empleado} ,
        type : 'POST',
        success : function(json) {
            sl_em_empleado1.val('').change();
            console.log(json);
        },
        error : function(xhr, status) {
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

    let url = get_url("gt_solicitante","alta_bd", {});

    $.ajax({
        url : url,
        data : {em_empleado_id: selected_empleado} ,
        type : 'POST',
        success : function(json) {
            sl_em_empleado2.val('').change();
            console.log(json);
        },
        error : function(xhr, status) {
            alert('Error, ocurrio un error al ejecutar la peticion');
            console.log({xhr, status})
        }
    });
});

let table1 = new DataTable('#table-autorizantes', {
    columns: [
        { title: 'Id' },
        { title: 'Autorizante' },
        { title: 'Acciones' },

    ]
});

let table2 = new DataTable('#table-solicitantes', {
    columns: [
        { title: 'Id' },
        { title: 'Solicitante' },
        { title: 'Acciones' },

    ]
});