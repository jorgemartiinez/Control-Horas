<?php 
session_start();

clearstatcache();
//si no existen los archivos se redirigirá al proceso de instalación
if(!filesize('connect/config.php') || !filesize('connect/BD.php')){
    $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';

    if(strpos($_SERVER['PHP_SELF'], 'recuperar-password') == false && strpos($_SERVER['PHP_SELF'], 'reset') == false && strpos($_SERVER['PHP_SELF'], 'panel') == false){
        $ruta = $protocol . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']). basename(dirname($_SERVER['PHP_SELF'])).'/';
    }else{
        $ruta = $protocol . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) .'/';
    }
    header( 'Location:'.$ruta . 'installation-1');
    exit();
}
require('connect/config.php'); //archivo config

if(isset($_SESSION['instalacion'])){
    header("Location:".$GLOBALS['config']['rutaAbsoluta'].$_SESSION['instalacion']);
    exit();
}

//si has iniciado sesión, entrarás en el panel
if(isset($_SESSION['usuario'])){ header("Location:".$GLOBALS['config']['rutaAbsoluta'].'panel'); }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Login Control Horas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Panel de Administración para control de horas de usuario, trabajos, clientes, packs, etc." name="description" />
    <meta content="PandaCreatiu" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Sweet Alert-->
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg" >

