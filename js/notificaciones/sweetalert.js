'use strict';


/* MENSAJES ÉXITO */
function mensajeExitoContacto() {
    return Swal.fire({
        title: '¡Se prendió la wea!',
        text: "Tu mensaje ha sido enviado correctamente",
        type: 'success',
        confirmButtonText: 'siiiiii'
    }).then((result) => {
        if (result.value) {
            location.reload();
        }
    })

}

/* MENSAJES ERROR */
