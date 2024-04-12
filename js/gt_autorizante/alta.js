$(document).ready(function () {

    let registro_id = getParameterByName('registro_id');
    let pr_procesos = $("#pr_procesos");
    let procesos_seleccionados = [];


    const columns_pr_proceso = [
        {
            title: "Id",
            data: "pr_proceso_id"
        },
        {
            title: "Tipo",
            data: "pr_proceso_descripcion"
        }
    ];

    const table_pr_proceso = table('pr_proceso', columns_pr_proceso, [], [], function () {}, true);

    $("#form_gt_autorizante_alta").on('submit', function (e) {
        if (procesos_seleccionados.length === 0) {
            e.preventDefault();
            alert("Seleccione como mínimo un proceso para el autorizante");
        }
    });

});





