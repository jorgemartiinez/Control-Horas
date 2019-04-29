'use strict';

window.addEventListener("load", function () {
    document.getElementById('close-show-descripcion').addEventListener('click', cerrarModal);
});


/* RECIBIMOS UNA ID DEL TRABAJO A ELIMINAR Y LLAMAMOS AL WARNING DE SWEET ALERT */
function deleteTrabajo (id, titulo){

    let dataString = 'trabajo=' + id;

    mensajeAJAXWarningBorrar('trabajos/del_trabajo.php', dataString);

}


