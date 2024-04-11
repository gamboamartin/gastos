$(document).ready(function () {

    let registro_id = getParameterByName('registro_id');

    const columns_pr_proceso = [
        {
            title: "Id",
            data: null,
            'checkboxes':{

                'selectRow':true
            },
        },
        {
            title: "Id",
            data: "pr_proceso_id"
        },
        {
            title: "Tipo",
            data: "pr_proceso_descripcion"
        }

    ];
    const callback_pr_proceso = (seccion, columns) => {
        return [
            {
                'targets': 0,
                'searchable': false,
                'orderable': false,
                'className': 'dt-body-center',
                'render': function (data, type, full, meta){
                    return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                }
            }
        ]
    }


    const table_pr_proceso = table('pr_proceso', columns_pr_proceso, [], [], callback_pr_proceso);

});





