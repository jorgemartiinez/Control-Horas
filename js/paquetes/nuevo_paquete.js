'use strict';

/* DESDE AQUÍ NOS ENCARGAREMOS DE AÑADIR UN PAQUETE EN BASE A PARÁMETROS RECIBIDOS DE UN UN FORMULARIO */

window.addEventListener("load", function () {

    document.getElementById("form-enviar-paquete").setAttribute('novalidate', 'novalidate');
    document.getElementById("form-enviar-paquete").addEventListener("submit", enviarPaquete);
});


//comprobamos los datos introducidos y añadimos paquete
function enviarPaquete(event){
    event.preventDefault();

    let horas = document.getElementById('horas');
    let cliente = document.getElementById('cliente');
    let meses = document.getElementById('meses');

    if(comprobarCampo(horas) && comprobarCampo(cliente) && comprobarCampo(meses)){

        let dataString = 'horas='+horas.value+'&cliente='+cliente.value+'&meses='+meses.value;

        $('#nuevo-paquete-modal .close').click();
        mensajeAJAXWarningEnviarCorreoNuevoPaquete('paquetes/add_paquete.php', dataString, cliente.value); //generamos la petición al aceptar el warning

    }
}