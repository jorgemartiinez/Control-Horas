<?php include('include/partials/install/header-install.php');
if(strpos($_SERVER['REQUEST_URI'], $_SESSION['instalacion']) == false){
    header('Location:'.$ruta.$_SESSION['instalacion']);
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
                            <i class="mdi mdi-alert-circle-outline font-15"></i> Y por último, para finalizar al instalación necesitará crear un usuario con el que poder acceder al panel. Tenga en cuenta que será el administrador principal y tendrá permiso para ejecutar todas las operaciones disponibles.
                        </div>
                        <form id="form-final-install">
                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input class="form-control" type="text" id="nombre" placeholder="Nombre" autofocus onkeyup="comprobarCampo(this)" required>
                                <small class="form-text text-info">Se utilizará cómo dato informativo.</small>
                            </div>
                            <div class="form-group">
                                <label for="nombre">Email</label>
                                <input class="form-control" type="email" id="email" placeholder="Email acceso" autofocus onkeyup="comprobarCampo(this)" required>
                                <small class="form-text text-info">Se utilizará para acceder al panel.</small>
                            </div>
                            <div class="form-group">
                                <label for="pass-1">Contraseña</label>
                                <input class="form-control" type="password" id="pass-1" placeholder="Contraseña" onkeyup="comprobarCampo(this)" minlength="6" required>
                            </div>
                            <div class="form-group">
                                <label for="pass-2">Repetir contraseña </label>
                                <input class="form-control" type="password" id="pass-2" placeholder="Repita su contraseña" onkeyup="comprobarCampo(this)" minlength="6" required>
                                <small class="form-text text-info">Contraseña acceso al panel.</small>
                            </div>
                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-success btn-block" type="submit"> Finalizar la instalación </button>
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
<script src="js/installation/installation-3.js"></script>

<?php include ('include/partials/install/footer-install.php') ?>

