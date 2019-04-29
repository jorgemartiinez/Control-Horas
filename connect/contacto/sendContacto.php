<?php

/* DESDE ESTE FICHERO SIMPLEMENTE NOS ENVIAREMOS UN CORREO
A NOSOTROS MISMOS CON LOS DATOS DEL CLIENTE Y LA DESCRIPCIÓN
DE PORQUE QUIERE CONTACTARNOS */

require ('../BD.php');
require ('../../utils/enviarCorreo.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['nombre'], $_POST['email'], $_POST['descripcion'])) { //comprobamos que tenemos todos los campos y los hemos recibido correctamente

    $nombre =htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $descripcion = htmlspecialchars($_POST['descripcion'], ENT_QUOTES, 'UTF-8');

    try {
        //nos enviamos un correo
        enviarCorreoContacto('Un usuario ha intentado ponerse en contacto con nosotros',
            'jorge@pandacreatiu.com', 'pandacreatiu.com',
            'send_contacto', $descripcion, $nombre, $email);

    } catch (phpmailerException $e) {
        echo $e->errorMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }


}
