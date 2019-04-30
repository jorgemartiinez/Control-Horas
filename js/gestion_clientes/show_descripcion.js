'use strict';

window.addEventListener("load", function () {
    document.getElementById('close-show-descripcion').addEventListener('click', cerrarModal);
});

function showDescripcion(id) {

    let dataString = 'trabajo='+ id +'&show=' + true;

    $.ajax({
        type: "GET",
        url: "connect/gestion_clientes/get_trabajo.php",
        data: dataString,
        contentType : 'application/json; charset=utf-8',
        success: function(data) {
            let trabajo = JSON.parse(data);

            let titulo = document.getElementById('show-titulo-text');

            let descripcion = document.getElementById('show-descripcion-text');

            let fecha = document.getElementById('show-fecha-text');


            (trabajo.titulo != 0)?
                titulo.innerHTML = trabajo.titulo:
                titulo.innerHTML = trabajo.descripcio.substr(0,30)+'...';

           descripcion.innerHTML = trabajo.descripcio;


           let fechaSinFormatear = new Date(trabajo.data_inici);

           fecha.innerHTML = fechaSinFormatear.toLocaleDateString();

           $('#abrir_modal_descripcion').trigger('click');
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function cerrarModal() {
    $("#show-descripcion-modal .close").click();
}
