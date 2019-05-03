'use strict';

/* DESDE AQUÍ NOS ENCARGAREMOS DE VALIDAR LOS DATOS INTRODUCIDOS EN EL FORMULARIO DE CONTACTO Y ENVIAR UN CORREO ELECTRÓNICO CUANDO TODO ESTE CORRECTAMENTE */

window.addEventListener("load", function () {
    document.getElementById("form-contacto").addEventListener("submit", enviarContacto);
    document.getElementById("form-contacto").setAttribute('novalidate', 'novalidate');
});


function enviarContacto(event) {
    event.preventDefault();

    let nombre = document.getElementById('nombre');
    let email = document.getElementById('email');
    let descripcion = document.getElementById('descripcion');
    let datosContacto = document.getElementById('datos-contacto');

    let validation = comprobarCampo(nombre) + comprobarCampo(email) + comprobarCampo(descripcion)+ comprobarCampo(datosContacto);

    if(validation==4){

        $('#enviarContacto').prop('disabled', true); //desactivamos el botón

        let dataString = 'nombre=' + nombre.value + '&email=' + email.value + '&descripcion=' + descripcion.value + '&datosContacto=' + datosContacto.value ;

        $.ajax({
            type: "POST",
            url: "connect/contacto/sendContacto.php", //enviamos parámetros para realizar el correo
            data: dataString,
            success: function (data) {
                mensajeCustomUnBoton("Mensaje enviado",
                    "El mensaje ha sido enviado correctamente. Nos pondremos en contacto con la mayor brevedad posible.",
                    "success");
            },
            error: function (xhr, ajaxOptions, thrownError) {
                mensajeGenericoError();
            }
        });
    }
}
