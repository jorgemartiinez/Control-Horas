'use strict';

window.addEventListener("load", function () {
    
    let formCaducar = document.getElementById("form-caducar-horas");

    if(formCaducar) {
        formCaducar.setAttribute('novalidate', 'novalidate');
        formCaducar.addEventListener('submit', caducarHoras);
    }
});


function caducarHoras(event) {
    event.preventDefault();

    let titulo = document.getElementById('titulo');
    let descripcion = document.getElementById('descripcion');
    let cliente = document.getElementById('cliente');
    let horas = document.getElementById('horas');


    if(comprobarCampo(titulo) && comprobarCampo(descripcion)
        && comprobarCampo(cliente) && comprobarCampo(horas)) {
        let dataString = 'titulo=' + titulo.value + '&descripcion=' + descripcion.value
            + '&cliente=' + cliente.value + '&horas=' + horas.value;

        $.ajax({
            type: "POST",
            url: "connect/gestion_clientes/add_caducar_horas.php",
            data: dataString,
            success: function (data) {

                if(data == 'OK'){
                    mensajeCustomUnBoton('Éxito', 'Horas del cliente caducadas correctamente', 'success');
                }else if (data =='error_saldo'){
                    mensajeCustomUnBoton('Error', 'El cliente debe tener un saldo mayor a 0 para poder caducar sus horas. ¿No querrás una tarea vacía?', 'error');
                }else {
                    mensajeGenericoError()
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
