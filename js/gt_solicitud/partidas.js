let btn_alta_producto = $("#btn-alta-producto");

let sl_com_producto = $("#com_producto_id");
let sl_cat_sat_unidad = $("#cat_sat_unidad_id");

let txt_cantidad = $("#cantidad");

let registro_id = getParameterByName('registro_id');

btn_alta_producto.click(function () {

    let producto = sl_com_producto.find('option:selected').val();
    let unidad = sl_cat_sat_unidad.find('option:selected').val();
    let cantidad = txt_cantidad.val();

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

    let url = get_url("gt_solicitud_producto", "alta_bd", {});

    $.ajax({
        url: url,
        data: {com_producto_id: producto, cat_sat_unidad_id: unidad, cantidad: cantidad, gt_solicitud_id: registro_id},
        type: 'POST',
        success: function (json) {
            sl_com_producto.val('').change();
            sl_cat_sat_unidad.val('').change();
            txt_cantidad.val('');


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



