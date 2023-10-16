let btn_alta_autorizante = $("#btn-alta-autorizante");

let sl_em_empleado = $(".autorizantes #em_empleado_id");

btn_alta_autorizante.click(function () {

    let selected_empleado = sl_em_empleado.find('option:selected').val();

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
            sl_em_empleado.val('').change();
            console.log(json);
        },
        error : function(xhr, status) {
            alert('Error, ocurrio un error al ejecutar la peticion');
            console.log({xhr, status})
        }
    });

});