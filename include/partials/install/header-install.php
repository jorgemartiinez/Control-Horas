<?php
session_start();
clearstatcache();
//obtenemos la ruta
$protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$ruta = $protocol . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']).'/';

if(isset($_SESSION['usuario'])){header("Location:".$ruta.'panel'); exit();}

//comprobamos si existen los ficheros y no hay una instalación en proceso
if(filesize('connect/config.php') && filesize('connect/BD.php') && !isset($_SESSION['instalacion'])) {header("Location:".$ruta);exit();}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Instalación Panel Control Horas</title>
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

<body class="authentication-bg authentication-bg-pattern">

