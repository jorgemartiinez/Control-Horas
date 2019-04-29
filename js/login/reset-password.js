'use strict';

/* DESDE AQUÍ NOS ENCARGAREMOS DE ENVIAR AL USUARIO UN CORREO ELECTRÓNICO CON UN TOKEN PARA QUE PUEDA ACCEDER AL FORMULARIO DE RESETEAR CONTRASEÑA */

window.addEventListener("load", function () {
    document.getElementById('form-reset-login').addEventListener('submit', cambiarContrasenya);
    document.getElementById('form-reset-login').setAttribute('novalidate', 'novalidate');
});

//función en la que el usuario introducirá su email, se le enviará un correo y se le llevará a la página de confirmación de correo
function cambiarContrasenya(event) {
    event.preventDefault();

    let email = document.getElementById('email-reset');

    if(comprobarCampo(email)) {
        let dataString = 'email=' + email.value;

        $.ajax({
            type: "POST",
            url: "connect/login/reset-password.php",
            data: dataString,
            success: function (data) {
                if(data.includes('OK')){ //si todo ha ido OK, se realiza una petición
                    $.ajax({
                        type: "POST",
                        url: "confirm-mail",
                        data: dataString,
                        success: function(data) {
                            window.location.href = 'confirm-mail?email=' + email.value; //redirigimos
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            mensajeGenericoError();
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    });

                }else if(data=='no_existe'){ //el usuario no existe
                    mensajeCustomUnBotonSinRecargar('Error', 'El usuario introducido no existe. Vuelva a intentarlo de nuevo.', 'error');
                }else if(data=='max_peticiones'){ //el usuario ha realizado ya 2 peticiones de cambio de contraseña
                    mensajeCustomUnBotonSinRecargar('Error', 'Ya ha solicitado almenos dos veces el cambio de contraseña, por lo que debería de haber recibido un correo para realizar el proceso. ' +
                        'En caso de no haberlo recibido, póngase en contacto.', 'error');
                } else{
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
