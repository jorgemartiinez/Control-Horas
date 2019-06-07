'use strict';

/* FICHERO QUE SERVIRÁ PARA GESTIONAR LOS USUARIOS (ADMIN, CLIENTES) */

window.addEventListener("load", function () {
    //Buscamos todos los formularios del programa y les añadimos el atributo noValidate ya que los vamos a validar nosotros.
    Array.from(document.forms).forEach(form=>{
        form.setAttribute('novalidate','novalidate');
    });

    document.getElementById("anyadir-cliente").addEventListener("submit", anyadirCliente);
    document.getElementById("form-editar-cliente").addEventListener("submit", updateCliente);
    document.getElementById('cancelar-form-nuevo-cliente').addEventListener("click", cerrarModalAnyadir);
    document.getElementById('cancelar-form-editar-cliente').addEventListener("click", cerrarModalEditar);
});


/*función que sirve para añadir un nuevo cliente, recibimos los parámetros, los validamos y enviamos al servidor. Al recibir la respuesta mostraremos un mensaje de
* éxito o error en base al mensaje recibido*/
function anyadirCliente(event) {
    event.preventDefault();

    let nombre = document.getElementById('nombre-nuevo');

    let email = document.getElementById('email-nuevo');

    let rol = document.getElementById('rol-nuevo');

    comprobarCampo(nombre);
    comprobarCampo(email);
    comprobarCampo(rol);

    let resultado = comprobarCampo(nombre) + comprobarCampo(email) +  comprobarCampo(rol);

    if(resultado===3) {
        let dataString = 'email='+email.value+'&nombre='+nombre.value+'&rol='+rol.value;
        $.ajax({
            type: "POST",
            url: "connect/clientes/add_cliente.php",
            data: dataString,
            success: function(data) {
                cerrarModalAnyadir();

                if(data.includes('OK')){
                    mensajeCustomUnBoton('OK', 'Usuario añadido correctamente. Se le enviará un email con los datos de acceso', 'success');

                }else if(data == 'ya_existe'){ //si el usuario ya existe
                    mensajeCustomUnBoton('Error', 'El usuario que ha intentado añadir ya existe', 'error');

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

/* Función para realizar una consulta a la base de datos y recibir la información de un usuario para mostrarla directamente en el modal y que sea más sencillo
editar sus datos
 */
function editarCliente(id) {

    $("div.error").remove(); //si hay algún div de error en otro modal, lo borramos

    let dataString = 'cliente='+ id ;

    $.ajax({
        type: "GET",
        url: "connect/clientes/get_cliente.php",
        data: dataString,
        success: function(data) {

            let cliente = JSON.parse(data); //recibimos los datos en formato json de php

            //los pintamos en los input
            document.getElementById('nombre-editar').value = cliente.nom;
            document.getElementById('email-editar').value = cliente.email;
            document.getElementById('id-cliente-editar').value = cliente.id;

            //abrimos el modal
            $('#obrir_editar_client').trigger('click');
        },
        error: function (xhr, ajaxOptions, thrownError) {
            cerrarModalAnyadir();
            mensajeGenericoError();
            alert(xhr.status);
            alert(thrownError);
        }
    });
}


/* función para actualizar el cliente una vez recibidos sus datos, recibimos los parámetros, los validamos y enviamos al servidor */

function updateCliente(event){

    event.preventDefault();

    let nombre = document.getElementById('nombre-editar');

    let email = document.getElementById('email-editar');

    let rol = document.getElementById('rol-editar');

    let id = document.getElementById('id-cliente-editar');

    if(comprobarCampo(nombre)&&comprobarCampo(email)&& comprobarCampo(rol)) {

        let dataString = 'nombre=' + nombre.value + '&email=' + email.value + '&rol=' + rol.value +  '&id=' + id.value + '&sesion=' + 0 ;

        $.ajax({
            type: "POST",
            url: "connect/clientes/update_cliente.php",
            data: dataString,
            success: function (data) {
                cerrarModalEditar();
                if(data.includes('OK')){
                    mensajeCustomUnBoton('OK', 'El usuario ha sido actualizado correctamente.', 'success');
                }else{
                    mensajeGenericoError();
                }

            },
            error: function (xhr, ajaxOptions, thrownError) {
                cerrarModalEditar();
                mensajeGenericoError();
                alert(xhr.status);
                alert(thrownError);
            }
        });

    }
}

/* función para cambiar el estado de un usuario, si está a 1 podrá acceder al sistema, en cambio si está a 0, no. */
function cambiarEstado(id, estado){

    estado = (estado == 0) ? 1 : 0;

    let mensaje = (estado == 0) ? 'suspendida' : 'activa';

    let dataString = 'estado='+ estado +'&id=' + id ; //enviamos el estado a actualizar y la id del cliente

    Swal.fire({
        title: 'Se cambiará el estado de esta cuenta a '+mensaje,
        text: "Tenga en cuenta de que en función de su estado el cliente podrá acceder o no al sitio. ¿Estás seguro?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: "connect/clientes/update_estado.php",
                data: dataString,
                success: function(data) {

                    if(data == 'OK'){ //se actualiza Ok
                        mensajeCustomUnBoton('OK',
                            'El estado del usuario ha sido actualizado correctamente.',
                            'success');
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
    });
}

/* BORRAMOS CLIENTE, LA FUNCIÓN SE ENCUENTRA EN LAS ALERTAS DE SWEET ALERT */
function deleteCliente(id){

    let dataString = 'id=' + id;

    mensajeAJAXWarningBorrar('clientes/del_cliente.php', dataString);

}


/* Función para subir una imagen al servidor, en este caso no queremos guardarla en sesión como si hacemos en perfil */

function abrirArchivos(client) {


    $('#subir-foto-perfil').trigger('click'); //al clicar en el lápiz abrimos un input para subir las imágenes */

    $("#subir-foto-perfil").change(function(){ //si detectamos algún cambio
        let foto_perfil = document.querySelector("input[type='file']").files[0]; //obtenemos el fichero

        let data = new FormData(); //creamos un objeto formdata, que nos servirá para almacenar el fichero que queremos subir

        data.append("subida", $("input[type='file']").prop('files')[0]);
        data.append("client", client); //cómo no queremos almacenarlo en sesión enviamos la variable cliente, que querrá decir que deberá
        // de actualizar por esta id y no por la de sesión

        let dataString = 'file='+data;

        /* CONSULTA PARA REALIZAR LA SUBIDA */
        $.ajax({
            type: "POST",
            url: "connect/perfil/update_photo.php",
            data: data,
            processData: false, // importante
            contentType: false, // importante

            success: function(data) {
                if(data == 'OK') {
                    mensajeCustomUnBoton('Operación realizada correctamente', 'La imagen ha sido subida correctamente y tu perfil ha sido actualizado', 'success');
                }else if(data == 'error_formato'){ //sube un archivo que no es una imagen
                    mensajeCustomUnBoton('Error formato', 'El archivo no es una imagen válida. Los formatos permitidos son png, jpg y jpeg. ', 'error')
                }else if(data == 'error_tamaño'){ //es demasiado grande
                    mensajeCustomUnBoton('Error tamaño', 'El archivo que has intentado subir es demasiado grande.', 'error')
                }
                else{ //error genérico
                    mensajeCustomUnBoton('Error al subir la imgen', 'Se ha producido un error al subir la imagen. Si el problema persiste, pongase en contacto con nuestro soporte técnico.', 'error')
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                mensajeGenericoError();
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });
}
//Cerrar modales
function cerrarModalAnyadir() {
    $("#anyadir-cliente-modal .close").click();
}

function cerrarModalEditar() {
    $("#editar-cliente-modal .close").click();
}

