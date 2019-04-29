<?php

if($_POST) {

    $hostBD = htmlspecialchars($_POST['hostBD']);
    $usuarioBD = htmlspecialchars($_POST['usuarioBD']);
    $nombreBD = htmlspecialchars($_POST['nombreBD']);
    $contrasenyaBD = htmlspecialchars($_POST['contrasenyaBD']);

    file_put_contents('../BD.php', "<?php \$mysqli = new mysqli('$hostBD' , '$usuarioBD', '$contrasenyaBD', '$nombreBD'); 
    \$mysqli->set_charset('utf8');
    if (\$mysqli->connect_error) {
    die( \"connect_error \") ;
    }else{
    die( \"connect_success \") ;
    }?>");

    require ('../BD.php');



}