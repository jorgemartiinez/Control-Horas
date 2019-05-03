<?php
include('include/partials/main/header-main.php');
include('include/partials/main/navbar-main.php');

//SÓLO PUEDE ACCEDER EL ADMIN
if($_SESSION['usuario']['rol']!=1){header("Location:".$GLOBALS['config']['rutaAbsoluta']);}
?>

<!-- ============================================================== -->
<!-- Start Page Content here -->
<!-- ============================================================== -->


<!-- Begin page -->
<div id="wrapper">
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid mb-5">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="panel">Panel</a></li>
                                    <li class="breadcrumb-item active" href="configuracion">Configuración</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Configuración</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="card-box">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="header-title">Configuración</h4>
                            <p class="sub-header">
                                Desde aquí usted podrá personalizar el panel de administración. Las opciones disponibles son; editar el logo que se muestra en la esquina superior izquierda, la información que se muestra en el footer (tanto en la página como en los emails) y cambiar la configuración de su hosting de correo electrónico.
                            </p>
                        </div>

                        <div class="col-12">

                            <div class="text-sm-center">
                                <div class="btn-group mb-3 ml-1">
                                    <button type="button" class="btn btn-primary" id="config-footer-button">Configuración footer</button>
                                    <button type="button" class="btn btn-light" id="config-mail-button">Configuración email</button>
                                </div>
                            </div>

                            <div id="apartado-config-footer">
                                <form id="form-config" enctype="multipart/form-data" method="post">
                                    <input type="file" id="logo-empresa" class="dropify" data-height="250" data-default-file="uploads/logo/<?=$_SESSION['config']['logo']?>" accept=".jpg, .jpeg, .png" data-allowed-file-extensions="png jpg jpeg"/>
                                    <small class="form-text text-info">No suba nada si no quiere actualizar la imagen. </small>

                                    <div class="form-group mb-3 mt-4">
                                        <label for="direccion-empresa">Dirección empresa</label>
                                        <input class="form-control" type="text" id="direccion-empresa" value="<?=$_SESSION['config']['footer-direccion']?>" onkeyup="comprobarCampo(this)" minlength="15" maxlength="200" required/>
                                        <small class="form-text text-info">Introduzca la dirección de su empresa. Mínimo 15 carácteres. Ejemplo de formato: Calle Codigo-Postal Ciudad (Provincia) </small>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="nombre-empresa">Nombre empresa</label>
                                        <input class="form-control" type="text" value="<?=$_SESSION['config']['footer-empresa']?>" id="nombre-empresa" onkeyup="comprobarCampo(this)" maxlength="200" required/>
                                        <small class="form-text text-info">Introduzca el nombre de su empresa. </small>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="email-empresa">Email empresa</label>
                                        <input class="form-control" type="email"  value="<?=$_SESSION['config']['footer-email']?>" id="email-empresa" onkeyup="comprobarCampo(this)" required/>
                                        <small class="form-text text-info">Introduzca la dirección de correo a mostrar en el pié de página. </small>
                                    </div>
                                    <div class="form-group mb-0 text-center">
                                        <button type="submit" class="btn btn-danger waves-effect waves-light">Editar configuración</button>
                                    </div>
                                </form>
                            </div>

                            <div id="apartado-config-mail" style="display:none">

                                <form id="form-email-install">
                                    <div class="form-group">
                                        <label for="host">Host correo</label>
                                        <input class="form-control" type="text" id="host" placeholder="host.dirección.dominio" autofocus onkeyup="comprobarCampo(this)" value="<?=HOST ?>" required>
                                        <small class="form-text text-info ">Dirección de hosting de su proveedor de correo. Ejemplo: smtp.gmail.com</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input class="form-control" type="text" id="nombre" onkeyup="comprobarCampo(this)" value="<?= FROM ?>" placeholder="Nombre" required>
                                        <small class="form-text text-info">Nombre que aparecerá cuando envíe un correo electrónico.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="correo">Correo electrónico</label>
                                        <input class="form-control" type="text" id="correo" placeholder="email@email.com" value="<?= USERNAME ?>" autofocus onkeyup="comprobarCampo(this)" required>
                                        <small class="form-text text-info">Dirección de correo con la que enviará los correos desde el panel. Será visible para todos sus clientes.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="pass">Contraseña correo</label>
                                        <input class="form-control" type="password" id="pass" onkeyup="comprobarCampo(this)" value="<?= PASSWORD ?>"
                                               required >
                                        <small class="form-text text-info">Contraseña de la cuenta de correo indicada en el campo anterior.</small>
                                    </div>
                                    <?php $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';$uri = $protocol . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']); ?>

                                    <div class="form-group">
                                        <input class="form-control" type="hidden" id="uri" value="<?=$uri?>" required>
                                    </div>
                                    <div class='form-group'>
                                        <label for='protocoloSeguridad'>Protocolo Seguridad</label>
                                        <select id='protocoloSeguridad' class='form-control' required >
                                            <option value='tls' name="protocoloSeguridad" <?php if(PROTOCOLO == 'tls'){ ?> selected <?php } ?>>TLS</option>
                                            <option value='ssl' name="protocoloSeguridad" <?php if(PROTOCOLO == 'ssl'){ ?> selected <?php } ?>>SSL</option>
                                        </select>
                                        <small class='form-text text-info'>Elija el protocolo de seguridad compatible con su correo electrónico.</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="opciones">Opciones SMTP</label>
                                        <div class="radio radio-success mb-2">
                                            <input type="radio" name="radio" id="radio4" value="1" required <?php if(OPCIONESSMTP == 1){ ?> checked <?php } ?>>
                                            <label for="radio4" class="text-success">
                                                Si
                                            </label>
                                        </div>

                                        <div class="radio radio-danger mb-2">
                                            <input type="radio" name="radio" id="radio6" value="0" <?php if(OPCIONESSMTP == 0){ ?> checked <?php } ?>>
                                            <label for="radio6" class="text-danger">
                                                No
                                            </label>
                                        </div>
                                        <small class="form-text text-info">Active las opciones SMTP si su host lo requiere.</small>
                                    </div>
                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-danger waves-effect waves-light" type="submit">Comprobar conexion y editar configuración</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div> <!-- end card-->
                    <!-- end row -->
                </div> <!-- end container -->
                <div class="col-12 text-center ">
                    <button class="btn btn-success waves-effect waves-light" onClick="history.go(-1)">Volver</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end wrapper -->

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    <!-- Scripts -->
    <!-- Editar configuración -->
    <script src="js/config/config.js" type="text/javascript"></script>

    <!-- Validación formularios -->
    <script src="js/validaciones/form-validation.js" type="text/javascript"></script>


    <!-- Instalacion fichero configuración js -->
    <script src="js/installation/installation-2.js"></script>

    <script>
        document.getElementById('logo-empresa').files[0] = new File([new Blob()], "uploads/logo/logo-light.png", {type:"image/png"});
    </script>

    <?php include('include/partials/main/footer-main.php');?>

