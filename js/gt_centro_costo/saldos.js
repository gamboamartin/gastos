$(document).ready(function () {

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
            title: "Etapa",
            data: "gt_orden_compra_etapa"
        },
        {
            title: "Cotizacion",
            data: "gt_orden_compra_cotizacion_gt_cotizacion_id"
        }
    ];

    const filtro_gt_orden_compra = [
        {
            "key": "gt_orden_compra.etapa",
            "valor": 'AUTORIZADA'
        }
    ];

    const extra_join_gt_orden_compra = [
        {
            "entidad": "gt_orden_compra_cotizacion",
            "key": "gt_orden_compra_id",
            "enlace": "gt_orden_compra",
            "key_enlace": "id",
            "renombre": "gt_orden_compra_cotizacion"
        }
    ];

    const table_gt_orden_compra = table('gt_orden_compra', columns_gt_orden_compra, filtro_gt_orden_compra, extra_join_gt_orden_compra, function () {
        
    });

});





