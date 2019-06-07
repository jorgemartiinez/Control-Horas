'use strict';

/* FICHERO QUE SERVIRÁ PARA CREAR LA BASE DE DATOS Y SU USUARIO DE ACCESO NECESARIO PARA LA APLICACIÓN */

window.addEventListener("load", function () {

    Array.from(document.forms).forEach(form=>{
        form.setAttribute('novalidate','novalidate');
    });

    document.getElementById("form-final-install").addEventListener("submit", finishConfig);
});


/* FINALIZAMOS LA CONFIGURACIÓN, UNA LLAMADA AJAX ES PARA CREAR LA BASE DE DATOS Y OTRA PARA CREAR EL ADMINISTRADOR */

function finishConfig(){
    event.preventDefault();

    let nombre = document.getElementById('nombre');
    let pass1 = document.getElementById('pass-1');
    let pass2 = document.getElementById('pass-2');
    let email = document.getElementById('email');


    if(pass1.value == pass2.value && pass1.value.length>=6) { //medidas seguridad password admin

        if (comprobarCampo(nombre) && comprobarCampo(pass1) &&
            comprobarCampo(pass2)&& comprobarCampo(email)) {

            let dataString = 'nombre=' + nombre.value + '&pass1=' + pass1.value + '&pass2=' + pass2.value+ '&email=' + email.value;

            Swal.fire({
                title: '¿Estás seguro de que quieres proceder con la instalación? Si la base de datos ya existe se borrará TODA su información.',
                text: "La operación será irreversible.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, acepto'
            }).then((result) => {
                if (result.value) {
                    $.ajax({ //crear BD
                        type: "POST",
                        url: "connect/installation/createBD.php",
                        data: dataString,
                        success: function (data) {
                            if(data.includes('OK')){
                                /* CREAR USUARIO */
                                $.ajax({
                                    type: "POST",
                                    url: "connect/installation/createAdminBD.php",
                                    data: dataString,
                                    success: function (data) {
                                        if(data.includes('OK')) { //OK
                                           mensajeCustomUnBotonSinRecargarYRedirect('¡Bien hecho!', 'Se ha completado la instalación del panel y ya está listo para su uso. Será redirigido al log in.', 'success', 'index')
                                        }else{
                                            mensajeGenericoError();
                                        }
                                    }
                                });

                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            mensajeCustomUnBotonSinRecargar('Error', 'Se ha producido un error al procesar la petición. Vuelva a intentarlo.', 'error');
                            //alert(xhr.status);
                            //alert(thrownError);
                        }
                    });
                }
            })

        }
    }else{
        mensajeCustomUnBotonSinRecargar('Error contraseña', 'Las contraseñas deben coincidir y tener un mínimo de 6 carácteres.', 'error');
    }

}
