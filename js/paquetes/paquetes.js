'use strict';

//ELIMINAR PAQUETE, RECIBIMOS ID Y ENVIAMOS LA PETICIÓN A TRAVÉS DE SWEETALERT SI ACEPTAMOS EL WARNING QUE NOS APARECERÁ.

function delPaquete(id) {
    let dataString = 'paquete=' + id;
    mensajeAJAXWarningBorrar('paquetes/del_paquete.php', dataString);
}


function abrirModal(cliente){
    document.getElementById('cliente').value = cliente;
    $('#abrir-nuevo-paquete').click();
}