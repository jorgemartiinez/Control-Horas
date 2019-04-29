'use strict';

window.addEventListener("load", function () {
    document.getElementById('close-show-descripcion').addEventListener('click', cerrarModal);
});



/* DESDE AQUÍ REALIZAREMOS UNA CONSULTA AL SERVIDOR PARA OBTENER LOS DATOS DE ESE TRABAJO Y MOSTRARLOS EN UN MODAL */

function showDescripcion(id) {

    let dataString = 'trabajo='+ id +'&show=' + true;

    $.ajax({
        type: "GET",
        url: "connect/trabajos/get_trabajo.php",
        data: dataString,
        contentType : 'application/json; charset=utf-8',
        success: function(data) {
            let trabajo = JSON.parse(data); //recibimos la info en json


            //insertamos la información en el modal
            let titulo = document.getElementById('show-titulo-text');

            let descripcion = document.getElementById('show-descripcion-text');

            let fecha = document.getElementById('show-fecha-text');


            (trabajo.titulo != 0)? //si la tarea no tiene título, cogemos los primeros 30 carácteres
                titulo.innerHTML = trabajo.titulo:
                titulo.innerHTML = trabajo.descripcio.substr(0,30)+'...';

           descripcion.innerHTML = trabajo.descripcio;


           let fechaSinFormatear = new Date(trabajo.data_inici);

           fecha.innerHTML = fechaSinFormatear.toLocaleDateString();

           $('#abrir_modal_descripcion').trigger('click'); //abrimos modal
        },
        error: function (xhr, ajaxOptions, thrownError) {
            mensajeGenericoError();
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

//cerrarModal
function cerrarModal() {
    $("#show-descripcion-modal .close").click();
}
