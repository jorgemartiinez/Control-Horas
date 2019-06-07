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
                                Desde aquí podrá personalizar el panel de administración. Las opciones disponibles son; editar el logo que se muestra en la esquina superior izquierda, la información que se muestra en el encabezado y pié de página (tanto en la página como en los emails) y cambiar la configuración de su hosting de correo electrónico.
                            </p>
                        </div>

                        <div class="col-12">

                            <div class="text-sm-center">
                                <div class="btn-group mb-3 ml-1">
                                    <button type="button" class="btn btn-primary" id="config-footer-button">Configuración encabezado y pié de página</button>
                                    <button type="button" class="btn btn-light" id="config-mail-button">Configuración email</button>
                                </div>
                            </div>

                            <?php if($_SESSION['usuario']['id']==1) { ?>
                                <div class="text-sm-center">
                                    <div class="btn-group mb-3 ml-1">
                                        <button type="button" class="btn btn-danger" id="config-avanzada-button">Configuración avanzada</button>
                                    </div>
                                </div>
                            <?php } ?>

                            <div id="apartado-config-footer" >
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
                                        <input class="form-control" type="text" id="host" placeholder="host.dirección.dominio" autofocus onkeyup="comprobarCampo(this)" value="<?= HOST ?>" required>
                                        <small class="form-text text-info ">Dirección de hosting de su proveedor de correo. Ejemplo: smtp.gmail.com</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input class="form-control" type="text" id="nombre" onkeyup="comprobarCampo(this)" value="<?= FROM ?>" placeholder="Nombre" required>
                                        <small class="form-text text-info">Nombre que aparecerá cuando envíe un correo electrónico.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="correo">Correo electrónico</label>
                                        <input class="form-control" type="text" id="correo" placeholder="Email" value="<?= USERNAME ?>" autofocus onkeyup="comprobarCampo(this)" required>
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

                            <?php if($_SESSION['usuario']['id']==1) { ?>
                                <div id="apartado-config-avanzada" style="display:none">

                                    <form id="form-restablecer-panel">
                                        <div class="form-group text-center">
                                            <button class="btn btn-warning waves-effect waves-light" type="submit">Restablecer panel</button>
                                            <small class="form-text text-muted">Se mantendrán los archivos de configuración y se volverá al estado en el que estaba el sistema justo después de la instalación. Sólo se mantendrán los usuarios que tengan el rol de administrador.
                                            </small>
                                        </div>
                                    </form>

                                    <form id="form-desinstalar-panel">
                                        <div class="form-group text-center">
                                            <button class="btn btn-warning waves-effect waves-light" type="submit">Desinstalar panel</button>
                                            <small class="form-text text-muted">Se borrará la base de datos, los archivos de configuración y todas las imágenes. Le devolverá al apartado de instalación inicial para volver a realizarla desde cero. </small>
                                        </div>
                                    </form>
                                </div>
                            <?php } ?>
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
    <a href="#modal-comprobar-password" class="btn btn-danger waves-effect waves-light invisible" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="abrir-modal-comprobarpass"> </a>


    <!-- Modal -->
    <div id="modal-comprobar-password" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.modal.close();" >
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title bg-danger">Comprobar contraseña</h4>
        <div class="custom-modal-text text-left">
            <p class="text-info">Para proceder, introduzca su contraseña.</p>
            <form id="check-pass-reinicio">
                <div class="form-group">
                    <label for="password-actual">Contraseña actual</label>
                    <input type="password" class="form-control" id="password-actual" name="password-actual" placeholder="Introduzca su contraseña actual." required>
                    <button class="btn btn-warning waves-effect waves-light" type="submit">Continuar</button>
                </div>
            </form>
        </div>
    </div>

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

    <?php include('include/partials/main/footer-main.php');?>

