<?php

/* DESDE ESTE FICHERO SIMPLEMENTE NOS ENVIAREMOS UN CORREO
A NOSOTROS MISMOS CON LOS DATOS DEL CLIENTE Y LA DESCRIPCIÓN
DE PORQUE QUIERE CONTACTARNOS */

require ('../BD.php');
require ('../config.php');
require ('../../utils/enviarCorreo.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST['nombre'], $_POST['email'], $_POST['descripcion'],$_POST['datosContacto'])) { //comprobamos que tenemos todos los campos y los hemos recibido correctamente

    $nombre =htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $descripcion = htmlspecialchars($_POST['descripcion'], ENT_QUOTES, 'UTF-8');
    $datosContacto = json_decode($_POST['datosContacto'], true);


    //COMPROBAMOS SI EL USUARIO HA CAMBIADO LOS DATOS EN EL APARTADO DE CONFIGURACIÓN, SI NO, OBTENEMOS EL VALOR DE LAS CONSTANTES
    if($datosContacto['footer-email'] == 'empresa@email.com' || $datosContacto['footer-email'] == ''){
        $emailReceptor = USERNAME;
    }else{
        $emailReceptor = $datosContacto['footer-email'];
    }

    if($datosContacto['footer-empresa'] == 'Nombre Empresa' || $datosContacto['footer-empresa'] == ''){
        $usuarioMail = FROM;
    }else{
        $usuarioMail = $datosContacto['footer-empresa'];
    }

    try {
        //nos enviamos un correo
        enviarCorreoContacto('Un usuario ha intentado ponerse en contacto con nosotros',
            $emailReceptor, $usuarioMail,
            'send_contacto', $descripcion, $nombre, $email);

    } catch (phpmailerException $e) {
        echo $e->errorMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }


}
