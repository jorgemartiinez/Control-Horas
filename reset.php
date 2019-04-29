<?php include('include/partials/login/header-login.php');
require ('connect/login/checkToken.php'); //comprobar que existe el token
if($existe == false){header("Location:".$GLOBALS['config']['rutaAbsoluta']);} ?>

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-pattern">
                    <div class="card-body p-4">
                        <div class="text-center w-75 m-auto">
                            <a href="index.html">
                                <span><img src="assets/images/logo-dark.png" alt="" height="22"></span>
                            </a>
                            <p class="text-muted mb-4 mt-3">Introduce tu nueva contraseña.</p>
                        </div>
                        <div class="alert alert-info bg-info text-white border-0" role="alert">
                            La contraseña deberá de contener un mínimo de 6 carácteres, con mayúsculas, minúsculas y números.
                        </div>
                        <form id="form-reset-pass">
                            <div class="form-group mb-23">
                                <label for="password">Contraseña</label>
                                <input class="form-control" type="password" id="password" required="" placeholder="Introduce tu contraseña" onChange="comprobarCampo(this)">
                            </div>

                            <input class="form-control" type="password" hidden id="token" value="<?php echo $_GET['token'] ?>" required>

                            <div class="form-group mb-3">
                                <label for="password-2">Repetir contraseña</label>
                                <input class="form-control" type="password" id="password-2" required="" placeholder="Repite tu contraseña" onChange="comprobarCampo(this)">
                            </div>

                            <div class="custom-control custom-checkbox mt-3 mb-3">
                                <input type="checkbox" class="custom-control-input" id="mostrarContrasenya">
                                <label class="custom-control-label" for="mostrarContrasenya">Mostrar contraseñas</label>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary btn-block" type="submit"> Reset Password </button>
                            </div>
                        </form>
                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->
                <!-- end row -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <div class="row mt-3">
        <div class="col-12 text-center">
            <p class="text-white-50">Volver a <a href="index" class="text-white ml-1"><b>Log in</b></a></p>
        </div> <!-- end col -->
    </div>
</div>
<!-- end page -->

<!-- Scripts -->
<!-- Comprobar y cambiar password-->
<script src="js/login/reset.js" type="text/javascript"></script>

<?php include('include/partials/login/footer-login.php'); ?>

