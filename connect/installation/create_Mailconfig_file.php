<?php
/* CREAMOS ARCHIVO DE CONFIGURACIÓN DE EMAIL EN BASE A LOS DATOS RECIBIDOS */

if(isset($_POST['host'],$_POST['email'],$_POST['nombre'],$_POST['contrasenya'],
    $_POST['protocoloSeguridad'],$_POST['opcionesSMTP'],$_POST['uri'])) {

    $host = htmlspecialchars($_POST['host']);
    $email = htmlspecialchars($_POST['email']);
    $nombre = htmlspecialchars($_POST['nombre']);
    $contrasenya = htmlspecialchars($_POST['contrasenya']);
    $protocoloSeguridad = htmlspecialchars($_POST['protocoloSeguridad']);
    $opcionesSMTP = htmlspecialchars($_POST['opcionesSMTP']);
    $uri = $_POST['uri'].'/';

    require ('../../utils/enviarCorreo.php');

    try {
        //nos enviamos un correo, utilizando la función de enviar correo de prueba que devolverá OK si se ha enviado correctamente
        $resultado = enviarCorreoPrueba($host, $email, $nombre, $opcionesSMTP, $protocoloSeguridad, $contrasenya);

        if($resultado == 'OK'){ //si se envía, creamos el archivo de configuración
            echo "OK";
            file_put_contents('../config.php',
                "<?php const USERNAME = '$email';const PASSWORD = '$contrasenya';const FROM = '$nombre';const PROTOCOLO = '$protocoloSeguridad';const HOST = '$host';const OPCIONESSMTP = '$opcionesSMTP';\$url= '$uri';\$GLOBALS['config']['rutaAbsoluta'] = \$url; ?>");

            $_SESSION['instalacion'] = 'installation-3'; //pasamos al siguiente paso de la instalación

        }else{
            echo "Error";
        }

    } catch (phpmailerException $e) {
        echo $e->errorMessage();
    } catch (Exception $e) {
        echo $e->getMessage();
    }

}

