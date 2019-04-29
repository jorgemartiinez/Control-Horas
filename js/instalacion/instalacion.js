'use strict';

/* FICHERO QUE SERVIRÁ PARA GESTIONAR EL ARCHIVO  */

window.addEventListener("load", function () {

    Array.from(document.forms).forEach(form=>{
        form.setAttribute('novalidate','novalidate');
    });

    document.getElementById("form-instalacion").addEventListener("submit", createConfigBD);
});


function createConfigBD(){
    event.preventDefault();

    let hostBD = document.getElementById('hostBD');
    let usuarioBD = document.getElementById('usuarioBD');
    let nombreBD = document.getElementById('nombreBD');
    let contrasenyaBD = document.getElementById('passwordBD');


    if(comprobarCampo(hostBD) && comprobarCampo(usuarioBD) &&
        comprobarCampo(nombreBD) && comprobarCampo(contrasenyaBD)){

        let dataString = 'hostBD='+hostBD.value+'&usuarioBD='+usuarioBD.value+'&nombreBD='+nombreBD.value+'&contrasenyaBD='+contrasenyaBD.value;

        $.ajax({
            type: "POST",
            url: "connect/installation/create_BDconfig_file.php",
            data: dataString,
            success: function(data) {
                if(data.includes('connect_error')){
                    mensajeCustomUnBotonSinRecargar('Error', 'No se ha podido establecer la conexión con la BD. Vuelva a intentarlo.', 'error');
                }else if(data.includes('connect_success')){
                    mensajeCustomUnBotonSinRecargarYRedirect('Bien hecho!', 'Se ha establecido conexión con la Base de Datos y se ha creado correctamente el fichero!', 'success', 'installation-2');
                }else{
                    mensajeCustomUnBotonSinRecargar('Error', 'No se ha podido establecer la conexión con la BD. Vuelva a intentarlo.', 'error');
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
