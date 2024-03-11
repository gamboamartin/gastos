
$(document).ready(function () {

    let registro_id = getParameterByName('registro_id');

    const columns_gt_cotizacion = [
        {
            title: "Id",
            data: "gt_cotizacion_id"
        },
        {
            title: "Tipo",
            data: "gt_tipo_cotizacion_descripcion"
        },
        {
            title: "Cotización",
            data: "gt_cotizacion_descripcion"
        },
        {
            title: "Etapa",
            data: "gt_cotizacion_etapa"
        }

    ];

    const filtro_gt_cotizacion = [
        {
            "key": "gt_cotizacion.gt_proveedor_id",
            "valor": registro_id
        }
    ];

    const table_gt_cotizacion = table('gt_cotizacion', columns_gt_cotizacion, filtro_gt_cotizacion, [], function () {

    });

});





