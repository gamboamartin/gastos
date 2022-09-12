function getAbsolutePath() {
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
}

let session_id = getParameterByName('session_id');


let txt_pagina_web = $("input[name=pagina_web]");
let pagina_web_regex = new RegExp('http(s)?:\\/\\/(([a-z])+.)+([a-z])+');
let pagina_web_error = $(".label-error-url");
let pagina_web_valido = false;
let btn_alta = $(".btn");

pagina_web_error.hide();
txt_pagina_web.change(function () {
    let url = $(this).val();
    pagina_web_valido = false;
    let regex_val = pagina_web_regex.test(url);
    let n_car = url.length;

    if(n_car > 0 && regex_val){
        pagina_web_valido = true;
    }

    if(!pagina_web_valido){
        pagina_web_error.show();
    } else {
        pagina_web_error.hide();
    }
});

btn_alta.on('click', function(  ){
    if(!pagina_web_valido){
        pagina_web_error.show();
        txt_pagina_web.focus();
        window.scrollTo(txt_pagina_web.positionX, txt_pagina_web.positionY);
        return false;
    }
});


