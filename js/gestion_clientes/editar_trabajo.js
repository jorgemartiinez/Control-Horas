'use strict';

window.addEventListener("load", function () {
    $('#summernote-editor').summernote();
    document.getElementById("form-editar-trabajo").setAttribute('novalidate', 'novalidate');
    document.getElementById("form-editar-trabajo").addEventListener("submit", editarTrabajo);

    document.getElementById('editar-completar').addEventListener('click', editarYCompletar);


});



function editarYCompletar(event) {
    event.preventDefault();

    let horas = document.getElementById('horas');
    let minutos = document.getElementById('minutos');


    if(minutos.value>0  || horas.value > 0) {
        let titulo = document.getElementById('titulo');
        let cliente = document.getElementById('cliente');
        let trabajo = document.getElementById('trabajo');

        let descripcion = $('#summernote-editor').summernote('code');


        if(comprobarCampo(titulo) && comprobarCampo(cliente) && comprobarCampo(trabajo)  && comprobarCampo(horas)  && comprobarCampo(minutos)){

            let dataString = 'trabajo='+trabajo.value +'&fin=si' +'&horas='+horas.value
                +'&minutos='+minutos.value +'&cliente='+cliente.value + '&titulo='+titulo.value +'&descripcion='+descripcion;

            mensajeAJAXWarningEnviarCorreo('gestion_clientes/update_trabajo.php', dataString, cliente.value);

        }

    }else{
        mensajeCustomUnBotonSinRecargar('Error', 'Almenos los minutos deben ser mayores a 0 para poder completar la tarea.', 'error');
    }

}


function editarTrabajo(event){
    event.preventDefault();


    let titulo = document.getElementById('titulo');
    let cliente = document.getElementById('cliente');
    let trabajo = document.getElementById('trabajo');

    let descripcion = $('#summernote-editor').summernote('code');

    let horas = document.getElementById('horas');
    let minutos = document.getElementById('minutos');


    if(comprobarCampo(titulo) &&  comprobarCampo(cliente)&& comprobarCampo(trabajo) ){

        let dataString = 'titulo='+titulo.value+'&horas='+'&descripcion='
            +descripcion+'&cliente='+cliente.value+'&trabajo='+trabajo.value+'&fin=no';

        $.ajax({
            type: "POST",
            url: "connect/gestion_clientes/update_trabajo.php",
            data: dataString,
            success: function(data) {
                if(data == 'OK'){
                    mensajeExistoRedirigir('OK', 'El trabajo ha sido actualizado correctamente.',  "trabajos?cliente="+cliente.value);
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