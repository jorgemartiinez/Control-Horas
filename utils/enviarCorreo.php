<?php
/*
 * FICHERO QUE SERVIRÁ PARA ENVIAR CORREOS ELECTRÓNICOS Y ASÍ PODER AHORRAR REPETIR CÓDIGO
 *
 */
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

const SMTP = "smtp";
const TIMEOUT = 30;
const CHARSET = "UTF-8";


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//INICIALIZAMOS UN NUEVO OBJETO PHPMAILER
function initCorreo($asunto, $to, $toName){
    require ('../../scripts/phpmailer/src/Exception.php');
    require ('../../scripts/phpmailer/src/PHPMailer.php');
    require ('../../scripts/phpmailer/src/SMTP.php');

    try {
        $mail = new PHPMailer(true);
        $mail->Mailer = SMTP;
        $mail->SMTPAuth = true;
        $mail->Timeout = TIMEOUT;
        $mail->Subject = $asunto;


        $mail->isSMTP();
        $mail->Host = HOST;
        $mail->SMTPAuth = true;

        if(OPCIONESSMTP == 1) {
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
        }

        $mail->SMTPSecure = PROTOCOLO;



            $mail->Port = 587;



        $mail->CharSet = CHARSET;
        $mail->SetFrom(USERNAME, FROM);
        $mail->AddAddress($to, $toName);
        $mail->isHtml(true);
        $mail->AltBody = "Para ver este mensaje, por favor utilice un gestor de correo compatible con HTML";

        $mail->Username = USERNAME;
        $mail->Password = PASSWORD;

    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }

    return $mail;
}

//CUANDO UN CLIENTE SE DA DE ALTA QUEREMOS ENVIAR UN CORREO CON SU USUARIO Y CONTRASEÑA
function enviarCorreoAltaCliente($asunto, $to, $toName, $archivo,
                       $password = null)
{

    try {

        $mail = initCorreo($asunto, $to, $toName);

        //incluir html con variables en el body
        ob_start();
        include('../../mail/'.$archivo.'.php');
        $body = ob_get_contents();
        ob_clean();
        $mail->Body = $body;

        if ($mail->send()) {
            echo "OK";
        }

    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}

//SI EL CLIENTE HA OLVIDADO LA CONTRASEÑA LE LLEGARÁ UN CORREO CON UN TOKEN QUE LE LLEVARÁ A UN FORMULARIO PARA ELLO
function enviarCorreoToken($asunto, $to, $toName, $archivo, $token){
    try {

        $mail = initCorreo($asunto, $to, $toName);

        //incluir html con variables en el body
        ob_start();
        include('../../mail/'.$archivo.'.php');
        $body = ob_get_contents();
        ob_clean();
        $mail->Body = $body;

        if ($mail->send()) {
            echo "OK";
        }

    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}

//SI UN CLIENTE QUIERE PONERSE EN CONTACTO CON NOSOTROS
function enviarCorreoContacto($asunto, $to, $toName, $archivo,  $descripcion = null, $nombreContacto = null, $emailContacto = null){
    try {

        $mail = initCorreo($asunto, $to, $toName);

        //incluir html con variables en el body
        ob_start();
        include('../../mail/'.$archivo.'.php');
        $body = ob_get_contents();
        ob_clean();
        $mail->Body = $body;

        if ($mail->send()) {
            echo "OK";
        }

    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}

//SI SE DA DE ALTA UN NUEVO PAQUETE DE HORAS, LOS PARÁMETROS SERÁN EL NÚMERO DE HORAS Y LA FECHA DE CADUCIDAD
function enviarCorreoNuevoPaquete($asunto, $to, $toName, $archivo, $numHoras = null,
                                  $fechaCaducidad = null){
    try {

        $mail = initCorreo($asunto, $to, $toName);

        //incluir html con variables en el body
        ob_start();
        include('../../mail/'.$archivo.'.php');
        $body = ob_get_contents();
        ob_clean();
        $mail->Body = $body;

        if ($mail->send()) {
            echo "OK";
        }

    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}


//CUANDO SE COMPLETA UNA TAREA, SE ENVIARÁ EL TÍTULO, LA DESCRIPCIÓN Y LO QUE HA DURADO LA MISMA EN H
function enviarCorreoTareaCompletada($asunto, $to, $toName, $archivo, $tituloTarea = null, $descripcionTarea=null, $duracion =null){
    try {

        $mail = initCorreo($asunto, $to, $toName);

        //incluir html con variables en el body
        ob_start();
        include('../../mail/'.$archivo.'.php');
        $body = ob_get_contents();
        ob_clean();
        $mail->Body = $body;

        if ($mail->send()) {
            echo "OK";
        }

    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}


function enviarCorreoPrueba($host, $to, $toName, $opcionesSMTP, $protocolo, $password){
    require ('../../scripts/phpmailer/src/Exception.php');
    require ('../../scripts/phpmailer/src/PHPMailer.php');
    require ('../../scripts/phpmailer/src/SMTP.php');

    try {
        $mail = new PHPMailer(true);
        $mail->Mailer = SMTP;
        $mail->SMTPAuth = true;
        $mail->Timeout = TIMEOUT;
        $mail->Subject = 'Prueba correo';
        $mail->isSMTP();
        $mail->Host = $host;
        $mail->SMTPAuth = true;

        if($opcionesSMTP == 1) {
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
        }
        $mail->SMTPSecure = $protocolo;
        $mail->Port = 587;
        $mail->CharSet = CHARSET;
        $mail->SetFrom($to,$toName);
        $mail->AddAddress($to, $toName);
        $mail->isHtml(true);
        $mail->AltBody = "Para ver este mensaje, por favor utilice un gestor de correo compatible con HTML";
        $mail->Username = $to;
        $mail->Password = $password;


        //incluir html con variables en el body
        ob_start();
        include('../../mail/send_prueba.php');
        $body = ob_get_contents();
        ob_clean();
        $mail->Body = $body;

        if ($mail->send()) {
            return "OK";
        }else{
            return "Error";
        }


    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}