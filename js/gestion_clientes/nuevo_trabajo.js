'use strict';

window.addEventListener("load", function () {
    document.getElementById("form-enviar-trabajo").setAttribute('novalidate', 'novalidate');
    document.getElementById("form-enviar-trabajo").addEventListener("submit", guardarTrabajo);
});



function guardarTrabajo(event){
    event.preventDefault();

    let titulo = document.getElementById('titulo');
    let horas = document.getElementById('horas');
    let descripcion = $('#summernote-editor').summernote('code');


    if(comprobarCampo(titulo) && comprobarCampo(cliente)){

        let dataString = 'titulo='+titulo.value+'&descripcion='+descripcion+'&cliente='+cliente.value;

        $.ajax({
            type: "POST",
            url: "connect/gestion_clientes/add_trabajo.php",
            data: dataString,
            success: function(data) {

                if(data == 'OK'){
                    mensajeExistoRedirigir('OK', 'El trabajo ha sido creado correctamente.',  "trabajos?cliente="+cliente.value);
                }else{
                    mensajeGenericoError();
                }

            },
            error: function (xhr, ajaxOptions, thrownError) {
                mensajeGenericoError();
                alert(xhr.status);
                alert(thrownError);
            }
        });

    }

}

