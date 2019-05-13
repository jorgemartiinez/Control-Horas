'use strict';

/* FICHERO QUE SERVIRÁ PARA ENVIAR AL SERVIDOR PARÁMETROS Y CREAR EL ARCHIVO DE CONFIGURACIÓN DE CORREO ELECTRÓNICO*/

window.addEventListener("load", function () {

    Array.from(document.forms).forEach(form=>{
        form.setAttribute('novalidate','novalidate');
    });

    document.getElementById("form-email-install").addEventListener("submit", createMailConfig);
});


/* FUNCIÓN CON LA QUE GENERAREMOS LA PETICIÓN */

function createMailConfig(){
    event.preventDefault();

    let host = document.getElementById('host');
    let uri = document.getElementById('uri');
    let email = document.getElementById('correo');
    let nombre = document.getElementById('nombre');
    let contrasenya = document.getElementById('pass');
    let protocoloSeguridad = document.getElementById('protocoloSeguridad');
    let opcionesSMTP = document.querySelector("input[type='radio']:checked");


    if(comprobarCampo(host) && comprobarCampo(email) &&
        comprobarCampo(nombre) && comprobarCampo(contrasenya)&& comprobarCampo(protocoloSeguridad) && comprobarCampo(uri)){

        let dataString = 'host='+host.value+'&email='+email.value+'&nombre='+nombre.value+'&contrasenya='
            +contrasenya.value+'&protocoloSeguridad='+protocoloSeguridad.value+'&opcionesSMTP='
            +opcionesSMTP.value+'&uri=' +uri.value;

        $.ajax({
            type: "POST",
            url: "connect/installation/create_Mailconfig_file.php",
            data: dataString,
            success: function(data) {
                if(data.includes('OK')) { //OK
                    mensajeCustomUnBoton('¡Bien hecho!', 'Se ha comprobado correctamente la conexión de correo electrónico. ', 'success')
                }else{
                    mensajeCustomUnBotonSinRecargar('Error', 'No se ha podido establecer la conexión con su hosting de correo electrónico. Vuelva a intentarlo.', 'error');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                mensajeCustomUnBotonSinRecargar('Error', 'No se ha podido establecer la conexión con su hosting de correo electrónico. Vuelva a intentarlo.', 'error');
            }
        });



    }


}
