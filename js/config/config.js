'use strict';

/* FICHERO QUE SERVIRÁ PARA GESTIONAR LA PÁGINA DE CONFIGURACIÓN */

window.addEventListener("load", function () {

    Array.from(document.forms).forEach(form=>{
        form.setAttribute('novalidate','novalidate');
    });

    document.getElementById("form-config").addEventListener("submit", updateConfig);

    document.getElementById("config-footer-button").addEventListener("click", selectConfigFooter);
    document.getElementById("config-mail-button").addEventListener("click", selectConfigMail);

    document.getElementById('mostrarContrasenya').addEventListener('click', mostrarContraseña);

});


/* SELECTORES PARA ELEGIR UN FORMULARIO U OTRO PARA CONFIGURAR EL PANEL */



/* SE ELIMINA LA CLASE Y SE CAMBIA EL DISPLAY PARA MOSTRAR O NO CADA APARTADO DE FORMULARIO */
function selectConfigFooter(event) {
    event.preventDefault();

   $("#apartado-config-footer").css('display', 'block');

    $("#apartado-config-mail").css('display', 'none');

    $("#config-footer-button").removeAttr('class').addClass('btn btn-primary');

    $("#config-mail-button").removeAttr('class').addClass('btn btn-light');

}

function selectConfigMail(event) {
    event.preventDefault();

    $("#apartado-config-mail").css('display', 'block');

    $("#apartado-config-footer").css('display', 'none');

    $("#config-mail-button").removeAttr('class').addClass('btn btn-primary');

    $("#config-footer-button").removeAttr('class').addClass('btn btn-light');

}

/* FUNCIÓN PARA ACTUALIZAR LA TABLA CONFIG, VALIDAREMOS LOS DATOS Y LOS ENVIAREMOS MEDIANTE UN OBJETO FORMDATA DESPUÉS DE VALIDARLOS,
EN ESTE CASO EL CAMPO LOGO ES OPCIONAL*/

function updateConfig(event) {
    event.preventDefault();

    let direccion = document.getElementById('direccion-empresa');
    let nombre = document.getElementById('nombre-empresa');
    let email = document.getElementById('email-empresa');


    if(comprobarCampo(direccion) && comprobarCampo(nombre) && comprobarCampo(email)) {

        let data = new FormData();

        data.append("logo", $("input[type='file']").prop('files')[0]); //recibimos imagen para realizar la petición
        data.append("nombre", nombre.value);
        data.append("email", email.value);
        data.append("direccion", direccion.value);

        $.ajax({
            type: "POST",
            url: "connect/config/update_config.php",
            data: data,
            processData: false, // importante
            contentType: false, // importante

            success: function (data) {
                if(data.includes('OK')) {
                    mensajeCustomUnBoton('Operación realizada correctamente', 'Configuración actualizada correctamente.', 'success');
                }else if(data == 'error_formato'){ //formato incorrecto
                    mensajeCustomUnBoton('Error formato', 'El logo subido no es una imagen válida. Los formatos permitidos son png, jpg y jpeg. ', 'error')
                }else if(data == 'error_tamaño'){ //imagen demasiado grande
                    mensajeCustomUnBoton('Error tamaño', 'El logo subido que has intentado subir es demasiado grande.', 'error')
                }
                else{
                    mensajeCustomUnBoton('Error al subir la imgen', 'Se ha producido un error al subir el logo. Si el problema persiste, pongase en contacto con nuestro soporte técnico.', 'error')
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