<?php
if(!isset($_SESSION)) {session_start(); }
if(isset($_SESSION['instalacion'])){
    $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $ruta = $protocol . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);
    header("Location:".$ruta.$_SESSION['instalacion']);
}
if(isset($_SESSION['usuario'])) { //si hemos iniciado sesión
    require('connect/config.php');  //config ruta absoluta
//si no has iniciado sesión, no podrás entrar al panel y te redigirá a login
    if (!isset($_SESSION['usuario'])) {
        header("Location:" . $GLOBALS['config']['rutaAbsoluta']);
    } else {
        if (!isset($_SESSION['config'])) {//obtenemos la configuración del footer si todavía no está inicializada
            require('connect/config/get_config.php');
        }
    };

    if ($_SESSION['last_activity'] < time() - $_SESSION['expire_time']) { //ha expirado la sesión?
        $_SESSION['expiredMail'] = $_SESSION['usuario']['email']; //almacenamos el email para mostrarlo cuando cerremos sesión e indicar que ha expirado la mismaQ
        unset($_SESSION['usuario']);
        $_SESSION['expired'] = 1; //expiramos y cerramos sesión
        header("Location:" . $GLOBALS['config']['rutaAbsoluta']);
    } else { //si no ha expirado
        $_SESSION['last_activity'] = time(); //se guarda el último momento en el que hubo actividad
    }

//este if sirve para comprobar que no se hayan alterado las variables de sesión
    if ($_SESSION['REMOTE_ADDR'] != $_SERVER['REMOTE_ADDR'] || $_SESSION['HTTP_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT']) {exit();}

}else{ //si no hay sesión
    $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $ruta = $protocol . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']);
    header("Location:".$ruta);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Panel de Control</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Panel de Administración para control de horas de usuario, trabajos, clientes, packs, etc." name="description" />
    <meta content="PandaCreatiu" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <!-- Bootstrap Tables css -->
    <link href="assets/libs/bootstrap-table/bootstrap-table.min.css" rel="stylesheet" type="text/css" />
    <!-- Summernote css -->
    <link href="assets/libs/summernote/summernote-bs4.css" rel="stylesheet" type="text/css" />
    <!-- Custom box css -->
    <link href="assets/libs/custombox/custombox.min.css" rel="stylesheet">
    <!-- Sweet Alert-->
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- Plugins css -->
    <link href="assets/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />

</head>

<body style="opacity: 0">

<!-- Topbar Start -->
<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-right mb-0">
        <?php if($_SESSION['usuario']['rol']==1){ ?>
            <li class="dropdown notification-list" >
                <?php /* obtenemos el número de trabajos pendientes*/ require ('connect/trabajos/getPendientes.php'); ?>
                <a class="nav-link dropdown-toggle  waves-effect waves-light" data-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="fe-bell noti-icon"></i>
                    <span class="badge badge-danger rounded-circle noti-icon-badge"><?= $numPendientes ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h5 class="m-0">
                       <span class="float-right">
                       </span>Notificaciones trabajos pendientes
                        </h5>
                    </div>
                    <div class="slimscroll noti-scroll">
                        <?php  /*si no hay trabajos pendientes no los pintamos */
                        if($numPendientes!=0){
                            foreach ($pendientes as $pendiente){ ?>
                                <!-- item-->
                                <a href="trabajos?cliente=<?= $pendiente['cliente']?>" title="Acceder a trabajos de <?php echo $pendiente['nom']?>" class="dropdown-item notify-item"> <!--active-->
                                    <div class="notify-icon">
                                        <img style="background-color: #FFF" src="scripts/TimThumb/mthumb.php?src=<?php echo "uploads/perfil/".$pendiente['perfil']; ?>&w=30&h=30&zc=2&q=95" class="img-fluid rounded-circle" alt="notificacion-trabajo <?php echo $pendiente['nom']?>" />
                                    </div>
                                    <p class="notify-details"><?php echo $pendiente['nom']?></p>
                                    <p class="text-muted mb-0 user-msg">
                                        <small>Tiene <?= $pendiente['pendientes'] ?> tarea/s pendiente/s</small>
                                    </p>
                                </a>
                            <?php }
                        }else{ ?>
                            <p class="text-muted mb-0 mt-1 text-center"><small> En este momento no tiene ningún trabajo pendiente.</small>
                            </p>
                        <?php } ?>
                    </div>
                </div>
            </li>
        <?php } ?>

        <li class="dropdown notification-list">

            <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false">
                <img style="background-color: #FFF" src="scripts/TimThumb/mthumb.php?src=<?php echo "uploads/perfil/".$_SESSION['usuario']['perfil']; ?>&w=50&h=50&zc=2&q=95" alt="user-image" class="rounded-circle ">
                <span class="pro-user-name ml-1">
                   <?php echo $_SESSION['usuario']['nom'] ?> <i class="mdi mdi-chevron-down"></i>
                </span>
            </a>

            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                <!-- item-->
                <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">¡Bienvenido!</h6>
                </div>

                <!-- item-->
                <a href="perfil" class="dropdown-item notify-item">
                    <i class="fe-user"></i>
                    <span>Mi cuenta</span>
                </a>

                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="logout" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>Cerrar sesión</span>
                </a>
            </div>
        </li>

        <?php if($_SESSION['usuario']['rol']==1){ ?>
            <li class="dropdown notification-list">
                <a href="configuracion" class="nav-link right-bar-toggle waves-effect">
                    <i class="fe-settings noti-icon"></i>
                </a>
            </li>
        <?php } ?>
    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="panel" class="logo text-center">
            <span class="logo-lg">
            <?php if($_SESSION['config']['logo'] != ''){ ?>
                <img src="uploads/logo/<?= $_SESSION['config']['logo'] ?>" alt="Logo" height="35">
            <?php } ?>
            </span>
            <span class="logo-sm">
                <img src="assets/images/favicon.ico" alt="Favicon" height="24">
            </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
        <li>
            <button class="button-menu-mobile waves-effect waves-light">
                <i class="fe-menu"></i>
            </button>
        </li>
    </ul>
</div>
<!-- end Topbar -->

