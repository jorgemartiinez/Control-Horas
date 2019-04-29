'use strict';

/* FICHERO QUE CONTENDRÁ LAS FUNCIONES NECESARIAS PARA REALIZAR LAS VALIDACIONES DE FORMULARIOS EN TODO EL PANEL */

function comprobarCampo(campo){
    let mensajeError = "";
    let divError = null;

    campo.setCustomValidity("");
    divError = campo.nextElementSibling;

    if(campo.checkValidity()){ //si se cumplen todas las condiciones, eliminaremos el error, y devolveremos true
        if(divError){
            campo.parentNode.removeChild(campo.nextElementSibling);
            campo.style.borderColor = "green";
        }
        return true;
    }else{ //si no se cumplen las condiciones, validaremos los diferentes tipos de entrada
        campo.setCustomValidity("");
        if(divError){ //comprobamos que exista, y lo borramos para volver a hacer las comprobaciones
            campo.parentNode.removeChild(campo.nextElementSibling);
        }
        if(campo.validity.valueMissing){ //que el valor sea obligatorio
            campo.setCustomValidity("El campo "+campo.id+" es obligatorio."); //personalizamos el mensaje
            pintarError(campo.validationMessage,campo); //lo enviamos a la función que pintará el error por pantalla
            return false;
        }else if(campo.validity.rangeUnderflow){ //es menor al rango requerido
            campo.setCustomValidity("El campo "+campo.id+" debe ser mayor a " + campo.min);
            pintarError(campo.validationMessage,campo); //enviamos el mensaje para generarar el error
            return false;
        }
        else if(campo.validity.rangeOverflow){ //es mayor al rango requerido
            campo.setCustomValidity("El campo "+campo.id+" debe ser menor de " + campo.max);
            pintarError(campo.validationMessage,campo); //enviamos el mensaje para generarar el error
            return false;
        }else if(campo.validity.badInput){ //no cumple el tipo de dato indicado en el input
            campo.setCustomValidity("El campo "+campo.id+" debe de ser del tipo " + campo.type);
            pintarError(campo.validationMessage,campo);
            return false;
        }else if(campo.validity.stepMismatch){ //no sigue el step indicado en el input
            campo.setCustomValidity("El campo "+campo.id+" no es correcto. Su valor debe de ir de " + campo.step + ' en ' + campo.step);
            pintarError(campo.validationMessage,campo);
            return false;
        } else if(campo.validity.tooLong){ //es demasiado grande
            campo.setCustomValidity("El campo "+campo.id+" debe ser menor de " + campo.maxLength + ' carácteres.');
            pintarError(campo.validationMessage,campo);
            return false;
        }else if(campo.validity.tooShort){ //es demasiado corto
            campo.setCustomValidity("El campo "+campo.id+" debe ser mayor de " + campo.minLength + ' carácteres.');
            pintarError(campo.validationMessage,campo);
            return false;
        }
        else if(campo.validity.typeMismatch){ //no es igual al type indicado en el html

            if(campo.type == 'email'){
                campo.setCustomValidity("El campo "+campo.id+" no es un email válido.");
            }else {
                campo.setCustomValidity("El campo " + campo.id + " no es un " + campo.type + " válido.");
            }

            pintarError(campo.validationMessage,campo);
            return false;
        }else if(campo.validity.tooShort){ //no cumple el pattern
           campo.setCustomValidity("El campo "+campo.id+" debe cumplir el patron indicado.");
           pintarError(campo.validationMessage,campo);
           return false;
        }
    }
}

//función que recibirá el mensaje y el campo al que darle este lo pintará después del input.
function pintarError(mensajeError,campo){
    campo.setCustomValidity("");

    campo.style.borderColor = "red";

    let div = document.createElement("div"); //se crea un div con un i que contendrá el mensaje
    div.className = 'mt-1';
    let span = document.createElement("span");
    span.className = "text-danger font-11";
    span.innerHTML+=mensajeError;
    div.appendChild(span);

    campo.parentNode.appendChild(div); //accedemos al padre (div) y añadimos el elemento creado después del input
}

