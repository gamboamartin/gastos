$(document).ready(function () {

    let registro_id = getParameterByName('registro_id');

    const columns_gt_orden_compra = [
        {
            title: "Id",
            data: `gt_orden_compra_id`
        },
        {
            title: "Tipo",
            data: 'gt_tipo_orden_compra_descripcion'
        },
        {
            title: "Orden Compra",
            data: 'gt_orden_compra_descripcion'
        },
        {
            title: "Proveedor",
            data: "gt_proveedor_descripcion"
        },
        {
            title: "Etapa",
            data: "gt_orden_compra_etapa"
        }
    ];

    const filtro_gt_orden_compra = [
        {
            "key": "gt_orden_compra.etapa",
            "valor": 'AUTORIZADA'
        },
        {
            "key": "gt_cotizacion.gt_centro_costo_id",
            "valor": registro_id
        }
    ];

    const extra_join_gt_orden_compra = [
        {
            "entidad": "gt_orden_compra_cotizacion",
            "key": "gt_orden_compra_id",
            "enlace": "gt_orden_compra",
            "key_enlace": "id",
            "renombre": "gt_orden_compra_cotizacion"
        },
        {
            "entidad": "gt_cotizacion",
            "key": "id",
            "enlace": "gt_orden_compra_cotizacion",
            "key_enlace": "gt_cotizacion_id",
            "renombre": "gt_cotizacion"
        },
        {
            "entidad": "gt_proveedor",
            "key": "id",
            "enlace": "gt_cotizacion",
            "key_enlace": "gt_proveedor_id",
            "renombre": "gt_proveedor"
        }
    ];

    const table_gt_orden_compra = table('gt_orden_compra', columns_gt_orden_compra, filtro_gt_orden_compra, extra_join_gt_orden_compra, function () {

    });

});





