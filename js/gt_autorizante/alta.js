$(document).ready(function () {

    let registro_id = getParameterByName('registro_id');

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

});





