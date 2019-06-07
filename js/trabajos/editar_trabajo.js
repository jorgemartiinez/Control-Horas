'use strict';


/* DESDE AQUÍ PODEMOS EDITAR UN TRABAJO, TENDREMOS DOS OPCIONES:
- EDITAR: NO SE ACTUALIZARÁN LAS HORAS NI ENVIARÁ EL CORREO AL CLIENTE YA QUE EL TRABAJO NO ESTÁ COMPLETADO.
- EDITAR Y COMPLETAR: SE ACTUALIZARÁN LAS HORAS Y SE ENVIARÁ UN CORREO AL CLIENTE INDICÁNDOLE QUE SU TRABAJO HA SIDO COMPLETADO.
 */


window.addEventListener("load", function () {
    $('#summernote-editor').summernote();
    document.getElementById("form-editar-trabajo").setAttribute('novalidate', 'novalidate');
    document.getElementById("form-editar-trabajo").addEventListener("submit", editarTrabajo); //si se produce un submit editamos

    document.getElementById('editar-completar').addEventListener('click', editarYCompletar); //si clickamos en editarYcompletar

});


//DESDE AQUÍ SE ACTUALIZAN LAS HORAS Y SE ENVÍA CORREO
function editarYCompletar(event) {
    event.preventDefault();

    let horas = document.getElementById('horas');
    let minutos = document.getElementById('minutos');


    if(minutos.value>0  || horas.value > 0) { //LAS HORAS DEBEN DE SER MAYORES A 0, ES UN TRABAJO COMPLETADO
        let titulo = document.getElementById('titulo');
        let cliente = document.getElementById('cliente');
        let trabajo = document.getElementById('trabajo');

        let descripcion = $('#summernote-editor').summernote('code'); //para recibir el valor del textarea del plugin summernote


        if(comprobarCampo(titulo) && comprobarCampo(cliente) && comprobarCampo(trabajo)  && comprobarCampo(horas)  && comprobarCampo(minutos)){ //comprobaciones

            let dataString = { titulo: titulo.value, descripcion:descripcion, cliente:cliente.value, trabajo:trabajo.value, fin: 'si', horas:horas.value, minutos:minutos.value};

            mensajeAJAXWarningEnviarCorreo('trabajos/update_trabajo.php', dataString, cliente.value); //generamos la petición al aceptar el warning

        }

    }else{
        mensajeCustomUnBotonSinRecargar('Error', 'Almenos los minutos deben ser mayores a 0 para poder completar la tarea.', 'error');
    }

}


//DESDE AQUÍ SE ACTUALIZAN LOS DATOS DE TÍTULO Y DESCRIPCIÓN, PERO NO DE HORAS, Y NO SE ENVÍA UN CORREO AL CLIENTE YA QUE TODAVÍA SE CONSIDERA COMO PENDIENTE
function editarTrabajo(event){
    event.preventDefault();


    let titulo = document.getElementById('titulo');
    let cliente = document.getElementById('cliente');
    let trabajo = document.getElementById('trabajo');

    let descripcion = $('#summernote-editor').summernote('code'); //valor plugin summernote

    let horas = document.getElementById('horas');
    let minutos = document.getElementById('minutos');


    if(comprobarCampo(titulo) &&  comprobarCampo(cliente)&& comprobarCampo(trabajo) ){ //validamos

        let dataString = { titulo: titulo.value, descripcion:descripcion, cliente:cliente.value, trabajo:trabajo.value, fin: 'no', horas:horas.value, minutos:minutos.value};

        /* Realizamos petición al servidor */
        $.ajax({
            type: "POST",
            url: "connect/trabajos/update_trabajo.php",
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