$(document).ready(function () {
    let btn_alta_producto = $("#btn-alta-producto");

    let sl_com_producto = $("#com_producto_id");
    let sl_cat_sat_unidad = $("#cat_sat_unidad_id");

    let txt_cantidad = $("#cantidad");
    let txt_precio = $("#precio");

    let registro_id = getParameterByName('registro_id');

    var productos_seleccionados = [];

    var tables = $.fn.dataTable.tables(true);
    var table_gt_cotizacion_producto = $(tables).DataTable().search('gt_cotizacion_producto');
    table_gt_cotizacion_producto.search('').columns().search('').draw();

    btn_alta_producto.click(function () {

        let producto = sl_com_producto.find('option:selected').val();
        let unidad = sl_cat_sat_unidad.find('option:selected').val();
        let cantidad = txt_cantidad.val();
        let precio = txt_precio.val();

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

        if (precio === "") {
            alert("Ingrese un precio");
            return;
        }

        let url = get_url("gt_cotizacion_producto", "alta_bd", {});

        $.ajax({
            url: url,
            data: {com_producto_id: producto, cat_sat_unidad_id: unidad, cantidad: cantidad, precio: precio, gt_cotizacion_id: registro_id},
            type: 'POST',
            success: function (json) {
                sl_com_producto.val('').change();
                sl_cat_sat_unidad.val('').change();
                txt_cantidad.val('');
                txt_precio.val('');

                if (json.hasOwnProperty("error")) {
                    alert(json.mensaje_limpio)
                    return;
                }

                table_gt_cotizacion_producto.ajax.reload();
            },
            error: function (xhr, status) {
                alert('Error, ocurrio un error al ejecutar la peticion');
                console.log({xhr, status})
            }
        });
    });

    const main_productos = (seccion, identificador) => {
        const ruta_load = get_url(seccion, "data_ajax", {ws: 1});


        return new DataTable(`#${identificador}`, {
            dom: 'Bfrtip',
            retrieve: true,
            ajax: {
                "url": ruta_load,
                'data': function (data) {
                    data.filtros = {
                        filtro: [
                            {
                                "key": "gt_orden_compra_cotizacion.gt_cotizacion_id",
                                "valor": registro_id
                            }
                        ],
                    }
                },
                "error": function (jqXHR, textStatus, errorThrown) {
                    let response = jqXHR.responseText;
                    console.log(response)
                }
            },
            columns: [
                {title: 'Id', data: `gt_orden_compra_id`},
                {title: 'Orden Compra', data: `gt_orden_compra_descripcion`},
                {title: 'Acciones', data: null},
            ],
            columnDefs: [
                {
                    targets: 2,
                    render: function (data, type, row, meta) {
                        let seccion = getParameterByName('seccion');
                        let accion = getParameterByName('accion');
                        let registro_id = getParameterByName('registro_id');

                        let url_elimina = $(location).attr('href');
                        url_elimina = url_elimina.replace(accion, "elimina_bd");
                        url_elimina = url_elimina.replace(seccion, `gt_orden_compra_cotizacion`);
                        url_elimina = url_elimina.replace(registro_id, row[`gt_orden_compra_cotizacion_id`]);

                        let url_actualiza = $(location).attr('href');
                        url_actualiza = url_actualiza.replace(accion, "modifica");
                        url_actualiza = url_actualiza.replace(seccion, "gt_orden_compra");
                        url_actualiza = url_actualiza.replace(registro_id, row[`gt_orden_compra_id`]);

                        let btn_actualiza = `<a href="${url_actualiza}" class="btn btn-warning btn-sm" style="margin: 0 15px;">Actualiza</a>`
                        let btn_elimina = `<button  data-url="${url_elimina}" class="btn btn-danger btn-sm">Elimina</button>`;

                        return `${btn_actualiza}${btn_elimina}`;
                    }
                }
            ]
        });
    }


    const table_2 = main_productos('gt_orden_compra_cotizacion', 'gt_orden_compra_cotizacion');


    table_2.on('click', 'button', function (e) {
        const url = $(this).data("url");

        $.ajax({
            url: url,
            type: 'POST',
            success: function (json) {
                if (json.includes('error')) {
                    alert("Error al eliminar el regstro")
                    return;
                }

                $('#table-productos').DataTable().clear().destroy();
                main_productos('gt_cotizacion_producto', 'productos');
            },
            error: function (xhr, status) {
                alert('Error, ocurrio un error al ejecutar la peticion');
                console.log({xhr, status})
            }
        });
    });

    let timer = null;

    $('#gt_cotizacion_producto').on('click', 'thead:first-child, tbody', function (event) {

        if (timer) {
            clearTimeout(timer);
        }

        timer = setTimeout(() => {
            var selectedData = table_gt_cotizacion_producto.rows('.selected').data();

            productos_seleccionados = [];

            selectedData.each(function (value, row, data) {
                productos_seleccionados.push(value.com_producto_id);
            });

            $('#agregar_producto').val(productos_seleccionados);
        }, 500);
    });

    $('#form-orden').on('submit', function(e){
        if(productos_seleccionados.length === 0) {
            e.preventDefault();
            alert("Seleccione un producto");
        }
    });

    let getData = async (url, acciones) => {
        fetch(url)
            .then(response => response.json())
            .then(data => acciones(data))
            .catch(err => {
                alert('Error al ejecutar');
                console.error("ERROR: ", err.message)
            });
    }

    sl_com_producto.change(function () {
        let selected = $(this).find('option:selected');

        let url = get_url("gt_cotizacion_producto","get_precio_promedio", {com_producto_id: selected.val()}, 0);

        getData(url,(data) => {
            txt_precio.val('');

            if (data.n_registros > 0) {
                txt_precio.val(data.registros[data.n_registros - 1].gt_cotizacion_producto_precio);
            }
        });

    });

});





