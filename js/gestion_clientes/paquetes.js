'use strict';

function delPaquete(id) {


    let dataString = 'paquete=' + id;

    mensajeAJAXWarningBorrar('gestion_clientes/del_paquete.php', dataString);

}


