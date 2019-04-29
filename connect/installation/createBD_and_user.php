<?php

if(isset($_POST['nombre'],$_POST['pass1'],$_POST['pass2'])) {

    require ('../../utils/myHelpers.php');
    require ('../BD.php');

    $nombre = $mysqli->real_escape_string($_POST['nombre']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $pass1 = $mysqli->real_escape_string($_POST['pass1']);
    $pass2 = $mysqli->real_escape_string($_POST['pass2']);
    $rol = 1;
    $fecha_alta = date('Y-m-d H:i:s');
    $encriptada = password_hash($pass1, PASSWORD_DEFAULT, $options); //LA ENCRIPTAMOS


    /* CREAMOS BD */
    $commands = file_get_contents('../ficheros_sql/controlhores.sql');

    if ($mysqli->multi_query($commands) === TRUE) {
        echo "OK";
    } else {
        echo "Error";
    }
}