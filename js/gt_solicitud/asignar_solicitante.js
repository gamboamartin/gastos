
let solicitante = document.getElementById("gt_solicitante_id");

let btn_alta = $(".btn");

let solicitante_duplicado_error = $(".label-error-solicitante");


solicitante_duplicado_error.hide();

btn_alta.on('click', function(  ){
    if(id_solicitante.includes(parseInt(solicitante.value))){
        solicitante_duplicado_error.show();
        return false;
    }
});