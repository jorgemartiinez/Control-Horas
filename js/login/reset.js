'use strict';

/* FORMULARIO ENCARGADO DE CAMBIAR LA CONTRASEÑA DEL USUARIO, SERÁ NECESARIO ACCEDER MEDIANTE UN TOKEN */


window.addEventListener("load", function () {
    document.getElementById('form-reset-pass').addEventListener('submit', cambiarContrasenya);
    document.getElementById('form-reset-pass').setAttribute('novalidate', 'novalidate');
    document.getElementById('mostrarContrasenya').addEventListener('click', mostrarContrasenya);

});


function cambiarContrasenya(event) {
    event.preventDefault();


    let pass = document.getElementById('password');

    let pass2 = document.getElementById('password-2');

    let token = document.getElementById('token');

    if(comprobarCampo(pass)&&comprobarCampo(pass2)) { //validamos
        let dataString = 'pass=' + pass.value+'&pass2='+pass2.value+'&token='+token.value;

        $.ajax({
            type: "POST",
            url: "connect/login/reset.php",
            data: dataString,
            success: function (data) {
                if(data == 'no_coinciden'){ //no coinciden las password
                    mensajeCustomUnBotonSinRecargar('No coinciden', 'Las contraseñas introducidas no coinciden.', 'error')
                }else if(data == 'error_pass'){ //no pasan las reglas de validación
                    mensajeCustomUnBotonSinRecargar('Error', 'La contraseña introducida debe contener un mínimo de 6 carácteres, con mayúsculas, minúsculas y algún número.', 'error')
                }else if(data == 'expirado' || data == 'necesario'){ //su token ha expirado o no lo ha introducido(dura 24 horas)
                    mensajeCustomResetPassword('Petición expirada', 'Su petición de cambio de contraseña ha expirado. Vuelva a solicitar el cambio de nuevo.', 'error');
                }else if(data == 'OK'){ //TODO OK, cambia la password y redirige al login
                    mensajeCustomResetPassword('Contraseña cambiada', 'La contraseña ha sido actualizada correctamente', 'success');
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


//mostramos las password si tildamos en mostrar contraseñas
function mostrarContrasenya(){
    let mostrarContrasenya = document.getElementById('mostrarContrasenya');
    let password = document.getElementById('password');
    let password2 = document.getElementById('password-2');

    if(mostrarContrasenya.checked){
        password.type = "text";
        password2.type = "text";

    }else{
        password.type = "password";
        password2.type = "password";
    }
}