

/* DESDE AQUÍ REALIZAREMOS LAS OPERACIONES NECESARIAS PARA EL PERFIL DE CADA USUARIO */

//listeners
window.addEventListener("load", function () {
    document.getElementById('editar-perfil').setAttribute('novalidate', 'novalidate' );
    document.getElementById('editar-perfil').addEventListener('submit', editarPerfil );
    document.getElementById('mostrarContrasenya').addEventListener('click', mostrarContrasenya );
    document.getElementById('editar-pass').addEventListener('submit', editarPassword );
});


//mostrar contraseña
function mostrarContrasenya(){
    let mostrarContrasenya = document.getElementById('mostrarContrasenya');
    let nuevaPassword = document.getElementById('nueva-password');
    let nuevaPassword2 = document.getElementById('nueva-password2');
    let contrasenyaActual = document.getElementById('password-actual');

    if(mostrarContrasenya.checked){
        nuevaPassword.type = "text";
        nuevaPassword2.type = "text";
        contrasenyaActual.type = "text";

    }else{
        nuevaPassword.type = "password";
        nuevaPassword2.type = "password";
        contrasenyaActual.type = "password";
    }

}


//Función para cambiar la contraseña desde tu perfil, validaremos los datos y realizaremos la petición al servidor
function editarPassword(event){
    event.preventDefault();

    let nuevaPass = document.getElementById('nueva-password');
    let nuevaPass2 = document.getElementById('nueva-password2');
    let contrasenyaActual = document.getElementById('password-actual');

    let dataString = 'nueva-password=' + nuevaPass.value + '&nueva-password2=' + nuevaPass2.value+'&password-actual=' + contrasenyaActual.value; //enviamos password

    $.ajax({
        type: "POST",
        url: "connect/perfil/update_password.php",
        data: dataString,
        success: function (data) {
            if (data == 'actual_error') { //no coinciden
                generarError('La contraseña actual no es correcta.');
                $('#password-actual').css('border-color', 'red');
                $('#nueva-password').removeAttr('border-color');
                $('#nueva-password2').removeAttr('border-color');
            } else if (data == 'no_coinciden') { //no pasan las reglas de validación
                generarError('Las nuevas contraseñas no coinciden.');
                $('#password-actual').css('border-color', 'green');
                $('#nueva-password').css('border-color', 'red');
                $('#nueva-password2').css('border-color', 'red');
            } else if (data == 'error_pass') { //no pasan las reglas de validación
                generarError('La nueva contraseña  deben contener 6 carácteres (minúsculas, mayúsculas y algún número)');
                $('#password-actual').css('border-color', 'green');
                $('#nueva-password').css('border-color', 'red');
                $('#nueva-password2').css('border-color', 'red');
            }
            else if (data == 'nueva_igual') { //la nueva es igual a la actual
                generarError('Las nueva contraseña debe ser diferente de la actual.');
                $('#password-actual').css('border-color', 'green');
                $('#nueva-password').css('border-color', 'red');
                $('#nueva-password2').css('border-color', 'red');
            }else if (data == 'OK') { //TODO OK
                cerrarModalContrasenya();
                mensajeCustomUnBoton('¡Bien!', 'Su contraseña ha sido actualizada correctamente. ', 'success');
            } else {
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


//al estar desde el modal no podemos utilizar sweet alert si se produce un error, por lo que lo pintamos en el mismo.
function generarError(textoError){

    // se crea un div con un p que tiene la clase de error y se pinta para informar al usuario del error

    let divErrores = document.getElementById('errores');
    let erroresPass = document.createElement('p');

    let existe = document.getElementById('errores-pass');

    if(existe) {
        divErrores.removeChild(existe);
    }
    createError(erroresPass,divErrores, textoError);
}

function createError(erroresPass, divErrores, textoError){


    erroresPass.setAttribute('id', 'errores-pass');
    erroresPass.setAttribute('class', 'alert alert-danger error');
    erroresPass.innerHTML = ' ' +textoError;
    divErrores.append(erroresPass);
}

/* Igual que la función que se realiza al actualizar la foto desde la tabla clientes, se crea un objeto formdata con la imagen que queremos actualizar,
a diferencia de este, no le pasamos el parámetro client, para que así el servidor sepa que tiene que actualizar la información de sesión
 */

function abrirArchivos(form) {

    $('#subir-foto-perfil').trigger('click'); //abrimos el input de imagen

    $("#subir-foto-perfil").change(function(){
        let foto_perfil = document.querySelector("input[type='file']").files[0];

        let data = new FormData();

        data.append("subida", $("input[type='file']").prop('files')[0]); //recibimos imagen para realizar la petición

        let dataString = 'file='+data;

        $.ajax({
            type: "POST",

            url: "connect/perfil/update_photo.php",
            data: data,
            processData: false, // importante
            contentType: false, // importante

            success: function(data) {
                if(data == 'OK') {
                    mensajeCustomUnBoton('Operación realizada correctamente', 'La imagen ha sido subida correctamente y se ha actualizado su usuario.', 'success');
                }else if(data == 'error_formato'){ //formato incorrecto
                    mensajeCustomUnBoton('Error formato', 'El archivo no es una imagen válida. Los formatos permitidos son png, jpg y jpeg. ', 'error')
                }else if(data == 'error_tamaño'){ //imagen demasiado grande
                    mensajeCustomUnBoton('Error tamaño', 'El archivo que has intentado subir es demasiado grande.', 'error')
                }
                else{
                    mensajeCustomUnBoton('Error al subir la imgen', 'Se ha producido un error al subir la imagen. Si el problema persiste, pongase en contacto con nuestro soporte técnico.', 'error')
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                mensajeGenericoError();
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });
}


//función para editar la información personal de un usuario, se indica que se actualiza la info de la sesion
function editarPerfil(event) {
    event.preventDefault();

    let nombre = document.getElementById('nombre');
    let email = document.getElementById('email');

    if (comprobarCampo(nombre) && comprobarCampo(email) ) { //comprobamos campos

        let dataString = 'nombre=' + nombre.value + '&email=' + email.value  + '&sesion=' + 1; //INDICAMOS QUE HAY QUE GUARDAR LA INFORMACIÓN EN SESIÓN

        /* Realizamos la petición al servidor */
        $.ajax({
            type: "POST",
            url: "connect/clientes/update_cliente.php",
            data: dataString,
            success: function (data) {
                cerrarModal();
                if(data == 'OK') { //todo OK
                    mensajeCustomUnBoton('Perfil actualizado', 'La información de tu perfil ha sido actualizada correctamente', 'success');
                } else if(data=='existe'){ //el usuario ya existe
                    mensajeCustomUnBoton('El usuario ya existe', 'El email que has introducido ya está vinculado a otro usuario', 'error');
                } else{
                    mensajeGenericoError();
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                cerrarModal();
                mensajeGenericoError();
            }
        });
    }
}


/* CERRAR MODALES Y ELIMINAR ERRORES */
function cerrarModal() {
    $('#editar-info-modal .close').click()
}

function cerrarModalContrasenya() {
    $('#editar-contrasenya-modal .close').click();
    let divErrores = document.getElementById('errores');
    let erroresPass = document.createElement('p');

    let existe = document.getElementById('errores-pass');

    if(existe) {
        divErrores.removeChild(existe);
    }

}