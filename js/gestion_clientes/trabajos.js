'use strict';

window.addEventListener("load", function () {
    document.getElementById('close-show-descripcion').addEventListener('click', cerrarModal);
});


function updateEstado(id, estado) {

    let dataString = 'trabajo='+id + '&estado=' + estado;

    if(estado == 0){


        mensajeAJAXWarningEnviarCorreo('gestion_clientes/update_trabajo_estado.php', dataString);
        

    }else{
        $.ajax({
            type: "POST",
            url: "connect/gestion_clientes/update_trabajo_estado.php",
            data: dataString,
            success: function(data) {
                if(data == 'OK'){
                    mensajeCustomUnBoton('OK', 'El estado del trabajo ha sido actualizado correctamente.',  "success");
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


function deleteTrabajo (id, titulo){


    let dataString = 'trabajo=' + id;


    mensajeAJAXWarningBorrar('gestion_clientes/del_trabajo.php', dataString);

}


