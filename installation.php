<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Panda Creatiu</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Instalación del panel de administración." name="description" />
    <meta content="Panda Creatiu" name="author" />
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
                            <p class="text-muted mb-4 mt-3">¿Todavía no te has instalado nuestro panel? ¡Solo te llevará unos minutos!</p>
                        </div>

                        <form id="form-instalacion">

                            <div class="form-group">
                                <label for="hostBD">Dirección Host</label>
                                <input class="form-control" type="text" id="hostBD" placeholder="Host" autofocus onkeyup="comprobarCampo(this)" required>
                            </div>
                            <div class="form-group">
                                <label for="usuarioBD">Usuario base de datos</label>
                                <input class="form-control" type="text" id="usuarioBD" required onkeyup="comprobarCampo(this)" placeholder="Usuario">
                            </div>
                            <div class="form-group">
                                <label for="nombreBD">Nombre base de datos</label>
                                <input class="form-control" type="text" required id="nombreBD" onkeyup="comprobarCampo(this)" placeholder="Base datos">
                            </div>
                            <div class="form-group">
                                <label for="passwordBD">Contraseña base datos</label>
                                <input class="form-control" type="password" required id="passwordBD" onkeyup="comprobarCampo(this)" placeholder="Contraseña">
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-success btn-block" type="submit"> Establecer conexión </button>
                            </div>

                        </form>

                        <div class="text-center">
                            <h5 class="mt-3 text-muted">Sign up using</h5>
                            <ul class="social-list list-inline mt-3 mb-0">
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github-circle"></i></a>
                                </li>
                            </ul>
                        </div>

                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-white-50">Already have account?  <a href="index" class="text-white ml-1"><b>Sign In</b></a></p>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->


<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>

<!-- App js -->
<script src="assets/js/app.min.js"></script>

<!-- Instalacion js -->
<script src="js/instalacion/instalacion.js"></script>

<!-- Form validation -->
<script src="js/validaciones/form-validation.js"></script>

<?php include ('include/partials/login/footer-login.php') ?>
