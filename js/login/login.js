'use strict';

/* DESDE AQUÍ VALIDAREMOS EL LOGIN DEL USUARIO */

window.addEventListener("load", function () {
    document.getElementById("form-login").addEventListener("submit", login);
    document.getElementById("form-login").setAttribute('novalidate', 'novalidate');
    document.getElementById('mostrarContrasenya').addEventListener('click', mostrarContrasenya);

});


function login(event) {

    event.preventDefault();

    let email = document.getElementById('email');

    let password = document.getElementById('password');

    let resultado = comprobarCampo(password) + comprobarCampo(email); //devolverá true o false en función de si está correcto, la suma de dos true es 2

    if(resultado===2){ //todo ok, procedemos a preparar la petición
        let dataString = 'email='+email.value+'&password='+password.value; //cadena con los parámetros

        $.ajax({
            type: "POST",
            url: "connect/login/login.php",
            data: dataString,
            success: function(data) {
                if(data == 'error_pass') { //contraseña mal introducida
                    mensajeCustomUnBotonSinRecargar('Error contraseña', 'La contraseña que ha intentado introducir es incorrecta.', 'error');
                } else if(data == 'error_no_existe'){ //usuario no existe
                    mensajeCustomUnBotonSinRecargar('Usuario no existe', 'La usuario que ha introducido no existe.', 'error');
                } else if(data=="error_estado"){ //su cuenta no está activa
                    mensajeCustomUnBotonSinRecargar('Usuario suspendido', 'El usuario que ha introducido tiene la cuenta suspendida. Póngase en contacto para más información.', 'error');
                }
                else if(data == 'OK'){ //TODO OK, inicia sesión
                    document.getElementsByTagName('button')[0].disabled = true;
                    mensajeCustomUnBoton('Bienvenido', 'Ha accedido correctamente al sitio.', 'success');
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

//mostramos las contraseñas en formato texto
function mostrarContrasenya(){
    let mostrarContrasenya = document.getElementById('mostrarContrasenya');
    let password = document.getElementById('password');

    if(mostrarContrasenya.checked){ //si está seleccioando
        password.type = "text";
    }else{
        password.type = "password";
    }
}