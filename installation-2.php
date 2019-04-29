<?php include('include/partials/install/header-install.php');

if(strpos($_SERVER['REQUEST_URI'], $_SESSION['instalacion']) == false){
    header('Location:'.$ruta.'/'.$_SESSION['instalacion']);
};

?>

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-pattern">
                    <div class="card-body p-4">
                        <div class="text-center w-75 m-auto mb-2">
                            <span><img src="assets/images/logo-dark.png" alt="" height="40"></span>
                        </div>
                        <div class="alert alert-info mt-2" role="alert">
                            <i class="mdi mdi-alert-circle-outline font-15"></i> A continuación usted deberá de introducir los datos necesarios para que configuremos su cuenta de correo electrónico. Esto le servirá para poder notificar a sus clientes desde la aplicación.
                        </div>
                        <form id="form-email-install">
                            <div class="form-group">
                                <label for="host">Host correo</label>
                                <input class="form-control" type="text" id="host" placeholder="host.dirección.dominio" autofocus onkeyup="comprobarCampo(this)" required>
                                <small class="form-text text-info ">Dirección de hosting de su proveedor de correo. Ejemplo: smtp.gmail.com</small>
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input class="form-control" type="text" id="nombre" onkeyup="comprobarCampo(this)" placeholder="Nombre" required>
                                <small class="form-text text-info">Nombre que aparecerá cuando envíe un correo electrónico.</small>
                            </div>
                            <div class="form-group">
                                <label for="correo">Correo electrónico</label>
                                <input class="form-control" type="text" id="correo" placeholder="email@email.com" autofocus onkeyup="comprobarCampo(this)" required>
                                <small class="form-text text-info">Dirección de correo con la que enviará los correos desde el panel. Será visible para todos sus clientes.</small>
                            </div>
                            <div class="form-group">
                                <label for="pass">Contraseña correo</label>
                                <input class="form-control" type="password" id="pass" onkeyup="comprobarCampo(this)" <?php if(isset($_POST['pass'])){?> value="<?=$_POST['pass']?>" <?php } ?>
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
                                    <option value='tls' selected name="protocoloSeguridad">TLS</option>
                                    <option value='ssl' name="protocoloSeguridad">SSL</option>
                                </select>
                                <small class='form-text text-info'>Elija el protocolo de seguridad compatible con su correo electrónico.</small>
                            </div>

                            <div class="form-group">
                                <label for="opciones">Opciones SMTP</label>
                                <div class="radio radio-success mb-2">
                                    <input type="radio" name="radio" id="radio4" value="1" required  checked>
                                    <label for="radio4" class="text-success">
                                        Si
                                    </label>
                                </div>

                                <div class="radio radio-danger mb-2">
                                    <input type="radio" name="radio" id="radio6" value="0">
                                    <label for="radio6" class="text-danger">
                                        No
                                    </label>
                                </div>
                                <small class="form-text text-info">Active las opciones SMTP si su host lo requiere.</small>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-success btn-block" type="submit">Comprobar y continuar con la instalación</button>
                            </div>
                        </form>
                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->

<!-- Instalacion js -->
<script src="js/installation/installation-2.js"></script>

<?php include ('include/partials/install/footer-install.php') ?>