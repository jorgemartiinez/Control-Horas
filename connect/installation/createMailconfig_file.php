<?php

if($_POST) {

    $host = htmlspecialchars($_POST['host']);
    $email = htmlspecialchars($_POST['email']);
    $nombre = htmlspecialchars($_POST['nombre']);
    $contrasenya = htmlspecialchars($_POST['contrasenya']);
    $protocoloSeguridad = htmlspecialchars($_POST['protocoloSeguridad']);
    $opcionesSMTP = htmlspecialchars($_POST['opcionesSMTP']);


echo $host;
    echo $email;
    echo $nombre;
    echo $contrasenya;
    echo $protocoloSeguridad;
    echo $opcionesSMTP;

}

