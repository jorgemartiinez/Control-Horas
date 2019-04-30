'use strict';

window.addEventListener("load", function () {
    document.getElementById("form-enviar-paquete").setAttribute('novalidate', 'novalidate');
    document.getElementById("form-enviar-paquete").addEventListener("submit", enviarPaquete);
});

function enviarPaquete(event){
    event.preventDefault();

    let horas = document.getElementById('horas');
    let cliente = document.getElementById('cliente');
    let meses = document.getElementById('meses');

    if(comprobarCampo(horas) && comprobarCampo(cliente) && comprobarCampo(meses)){

        let dataString = 'horas='+horas.value+'&cliente='+cliente.value+'&meses='+meses.value;

        $.ajax({
            type: "POST",
            url: "connect/gestion_clientes/add_paquete.php",
            data: dataString,
            success: function(data) {
                if(data.includes('OK')){
                    mensajeExistoRedirigir('OK', 'El paquete ha sido añadido correctamente.',  "paquetes?cliente="+cliente.value);
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