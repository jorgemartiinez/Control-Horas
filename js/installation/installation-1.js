'use strict';

/* FICHERO QUE SERVIRÁ PARA GESTIONAR EL ARCHIVO  */

window.addEventListener("load", function () {


    mensajeCustomUnBotonSinRecargar('Hemos detectado que no tiene instalado nuestro panel.', 'Por lo tanto, se va a proceder con la instalación. ' +
        'Tenga en cuenta que dejar la instalación a medias puede causar problemas de configuración.', 'info');


    Array.from(document.forms).forEach(form=>{
        form.setAttribute('novalidate','novalidate');
    });

    document.getElementById("form-installation").addEventListener("submit", createConfigBD);


});

/* DESDE AQUÍ ENVIAREMOS AL SERVIDOR LOS PARÁMETROS NECESARIOS PARA CREAR EL ARCHIVO DE CONFIGURACIÓN DE LA BASE DE DATOS */

function createConfigBD() {
    event.preventDefault();

    let hostBD = document.getElementById('hostBD');
    let usuarioBD = document.getElementById('usuarioBD');
    let nombreBD = document.getElementById('nombreBD');
    let contrasenyaBD = document.getElementById('passwordBD');


    if (comprobarCampo(hostBD) && comprobarCampo(usuarioBD) &&
        comprobarCampo(nombreBD) && comprobarCampo(contrasenyaBD)) {

        let dataString = 'hostBD=' + hostBD.value + '&usuarioBD=' + usuarioBD.value + '&nombreBD=' + nombreBD.value + '&contrasenyaBD=' + contrasenyaBD.value;

        $.ajax({
            type: "POST",
            url: "connect/installation/create_BDconfig_file.php",
            data: dataString,
            success: function (data) {
                if (data.includes('connect_error')) { //error conexión
                    mensajeCustomUnBotonSinRecargar('Error', 'No se ha podido establecer la conexión con la BD. Vuelva a intentarlo.', 'error');
                } else if (data.includes('connect_success')) { //conexión OK
                    mensajeExistoRedirigir('OK', 'Se ha establecido conexión con la Base de Datos y se ha creado correctamente el fichero de configuración.', 'installation-2');
                } else {
                    mensajeCustomUnBotonSinRecargar('Error', 'No se ha podido establecer la conexión con la BD. Vuelva a intentarlo.', 'error');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                mensajeCustomUnBotonSinRecargar('Error', 'Se ha producido un error al procesar la petición. Vuelva a intentarlo.', 'error');
                //alert(xhr.status);
                //alert(thrownError);
            }
        });
    }
}

