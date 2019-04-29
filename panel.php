<?php
session_start();
include('include/partials/main/header-main.php');
include('include/partials/main/navbar-main.php');
?>
<?php if($_SESSION['usuario']['rol']){ //es admin, añade panel de admin
    include_once ('include/panel/admin_panel.php');
}else{ //es cliente, añade panel de cliente
    include_once ('ficha.php');
}
?>
<?php include('include/partials/main/footer-main.php');?>
