<?php
/* DESDE ESTE FICHERO CREAREMOS EL FICHERO NECESARIO PARA GENERAR LA CONFIGURACIÓN QUE SERVIRÁ PARA CONECTARNOS A LA BASE DE DATOS */

if(isset($_POST['hostBD'],$_POST['usuarioBD'],$_POST['nombreBD'],$_POST['contrasenyaBD'])) {

    $hostBD = htmlspecialchars($_POST['hostBD']);
    $usuarioBD = htmlspecialchars($_POST['usuarioBD']);
    $nombreBD = htmlspecialchars($_POST['nombreBD']);
    $contrasenyaBD = htmlspecialchars($_POST['contrasenyaBD']);
    $estadoQuery = false;

    $mysqli = new mysqli($hostBD , $usuarioBD, $contrasenyaBD, $nombreBD);
    $mysqli->set_charset('utf8');

    if ($mysqli->connect_error) {
        echo "connect_error";
    }else{ //si no da ningún error de conexión, escribimos el fichero
        $estadoQuery = true;
        echo "connect_success";
        file_put_contents('../BD.php', "<?php \$mysqli = new mysqli('$hostBD' , '$usuarioBD', '$contrasenyaBD', '$nombreBD'); \$mysqli->set_charset('utf8');  if (\$mysqli->connect_error) {die('Connection failed: ' . \$mysqli->connect_error);} ?>");
    }

    require ('../BD.php');

    session_start();
    $_SESSION['instalacion'] = 'installation-2';
}