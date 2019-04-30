<?php include('include/partials/install/header-install.php');

if(!isset($_SESSION['instalacion'])) {
    $_SESSION['instalacion'] = 'installation-1'; //inicializamos variable de sesión para comprobar que se ejecuta la instalación en el orden deseado
}else{
    if(strpos($_SERVER['REQUEST_URI'], $_SESSION['instalacion']) == false){ //si no estamos en la página que toca de la instalación
        header('Location:'.$ruta.$_SESSION['instalacion']);
    }
}
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
                            <i class="mdi mdi-alert-circle-outline font-15"></i> En primera instancia deberá de introducir la información necesaria para que podamos establecer conexión con su base de datos y así poderle instalar el panel. <br/> No te preocupes, ¡sólo te llevará unos <strong>minutos</strong>!
                        </div>

                        <form id="form-installation">
                            <div class="form-group">
                                <label for="hostBD">Dirección Host</label>
                                <input class="form-control" type="text" id="hostBD" placeholder="host.dirección.dominio" autofocus onkeyup="comprobarCampo(this)" required>
                                <small class="form-text text-info">Dirección de hosting de su base de datos. Ejemplo: vl19749.dinaserver.com</small>
                            </div>
                            <div class="form-group">
                                <label for="usuarioBD">Usuario base de datos</label>
                                <input class="form-control" type="text" id="usuarioBD" required onkeyup="comprobarCampo(this)" placeholder="Nombre usuario">
                                <small class="form-text text-info">Nombre del usuario que tiene acceso a su base de datos.</small>
                            </div>

                            <div class="form-group">
                                <label for="passwordBD">Contraseña base datos</label>
                                <input class="form-control" type="password" required id="passwordBD" onkeyup="comprobarCampo(this)" placeholder="Contraseña">
                                <small class="form-text text-info">Contraseña del usuario que tiene acceso a su base de datos.</small>
                            </div>

                            <div class="form-group">
                                <label for="nombreBD">Nombre base de datos</label>
                                <input class="form-control" type="text" required id="nombreBD" onkeyup="comprobarCampo(this)" placeholder="Nombre base datos">
                                <small class="form-text text-info">Nombre de la base de datos a la que quiere importar el panel.</small>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-success btn-block" type="submit"> Establecer conexión y continuar con la instalación</button>
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
<script src="js/installation/installation-1.js"></script>

<?php include ('include/partials/install/footer-install.php') ?>
