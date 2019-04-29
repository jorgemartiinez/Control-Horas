'use strict';

/*
    ALERTAS SWEET ALERT
  *
  * AQUÍ SE DEFINIRÁN LAS ALERTAS QUE IRÁN UTILIZÁNDOSE EN LA APLICACIÓN
  *
  * */


/* MENSAJES GENÉRICOS */


function mensajeCustomUnBoton(titulo, texto, tipo) {
    return Swal.fire({
        title: titulo,
        text: texto,
        type: tipo,
        confirmButtonText: 'OK',
    }).then(function () {
        location.reload();
    });
}

function mensajeCustomUnBotonSinRecargar(titulo, texto, tipo) {
    return Swal.fire({
        title: titulo,
        text: texto,
        type: tipo,
        confirmButtonText: 'OK'
    })
}

function mensajeCustomUnBotonSinRecargarYRedirect(titulo, texto, tipo, file) {
    return Swal.fire({
        title: titulo,
        text: texto,
        type: tipo,
        confirmButtonText: 'OK'
    }).then(function () {
        window.location.href = file;
    });
}

function mensajeCustomResetPassword(titulo, texto, tipo) {
    return Swal.fire({
        title: titulo,
        text: texto,
        type: tipo,
        confirmButtonText: 'OK',
    }).then(function () {
        window.location.href = "index";
    });
}


/*
        MENSAJES ÉXITO
                            */


function mensajeExitoGenerico() {
    return Swal.fire({
        title: '¡Bien hecho!',
        text: 'Operación realizada correctamente.',
        type: 'success',
        confirmButtonText: 'OK',
    }).then(function () {
        location.reload();
    });
}



function mensajeExistoRedirigir(titulo, texto, ruta) {
    return Swal.fire({
        title: titulo,
        text: texto,
        type: 'success',
        confirmButtonText: 'OK',
    }).then(function () {
        window.location.href = ruta;
    });
}



/*
        MENSAJES ERROR
                            */


function mensajeGenericoError(){
    return Swal.fire({
        title: 'Error',
        text: 'Se ha producido un error al realizar la operación. Vuelva a intentarlo y si el problema persiste, pongase en contacto con nuestro soporte.',
        type: 'error',
        confirmButtonText: 'OK',
    }).then(function () {
        location.reload();
    });
}


/*
        MENSAJES WARNING
                            */
//recibe la ruta de un archivo dentro de connect y los parámetros para realizar la petición en caso de que se acepte el warning
function mensajeAJAXWarningBorrar(ruta, dataString) {

    Swal.fire({
        title: '¿Estás seguro de que quieres borrar el item seleccionado?',
        text: "Esta operación puede ser irreversible.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borralo'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "connect/"+ruta,
                data: dataString,
                success: function (data) {
                    if(data == 'OK'){
                        mensajeExitoGenerico();
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
    })
}


//recibe la ruta de un archivo dentro de connect y los parámetros para realizar la petición en caso de que se acepte el warning y ademñas recibe el id del cliente
//al que vamos a realizar el correo

function mensajeAJAXWarningEnviarCorreo(ruta, dataString, cliente) {

    Swal.fire({
        title: 'Se cambiará el estado a completado y se enviará un correo al cliente. ¿Estás seguro?',
        text: "Esta operación puede ser irreversible",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, estoy seguro'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "connect/"+ruta,
                data: dataString,
                success: function (data) {
                    if(data.includes('OK')){
                        mensajeExistoRedirigir('Éxito', 'El trabajo ha sido completado y se ha enviado un email al cliente', "trabajos?cliente="+cliente)
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
    })
}

function mensajeAJAXWarningEnviarCorreoNuevoPaquete(ruta, dataString, cliente) {

    Swal.fire({
        title: 'Se creará un nuevo paquete y se enviará un correo al cliente. ¿Estás seguro?',
        text: "Esta operación puede ser irreversible",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, estoy seguro'
    }).then((result) => {
        $('#form-enviar-paquete').append('<button type="submit" class="btn btn-primary">Enviar</button>');
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "connect/"+ruta,
                data: dataString,
                success: function (data) {
                    if(data.includes('OK')){
                        mensajeExistoRedirigir('Éxito', 'El paquete ha sido creado correctamente y se ha enviado un email al cliente', "paquetes?cliente="+cliente)
                    }else{
                        mensajeCustomUnBotonSinRecargar('Error', 'Se ha producido un error al añadir el paquete', 'error');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    mensajeGenericoError();
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }
    })
}