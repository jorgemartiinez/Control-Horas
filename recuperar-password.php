<?php include('include/partials/login/header-login.php'); ?>

<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-pattern">

                    <div class="card-body p-4">
                        <div class="text-center" style="background-color: #566676;  border-radius: 6px; ">
                            <?php if(isset($_SESSION['config'])&&$_SESSION['config']!=null){ ?>
                                <span class="text-center"><img src="<?='uploads/logo/'.$_SESSION['config']['logo']?>" alt=" <?=$_SESSION['config']['footer-empresa']?>" height="50"></span>
                            <?php } ?>
                            <p class="text-white mb-4 mt-3">Introduzca su correo electrónico y le enviaremos un email con un enlace que servirá para cambiar su contraseña.</p>

                        </div>

                        <form id="form-reset-login">

                            <div class="form-group mb-3">
                                <label for="emailaddress">Correo electrónico</label>
                                <input class="form-control" type="email" id="email-reset" required="" placeholder="Introduce tu email" onChange="comprobarCampo(this)" autofocus>
                            </div>

                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-primary btn-block" type="submit"> Reiniciar Contraseña</button>
                            </div>
                        </form>
                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

                <div class="row mt-3">
                    <div class="col-12 text-center">
                        <p class="text-white-50">Volver a <a href="index" class="text-white ml-1"><b>Log in</b></a></p>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>


<!-- Scripts -->
<!-- Validar y enviar correo -->
<script src="js/login/reset-password.js" type="text/javascript"></script>

<?php include('include/partials/login/footer-login.php'); ?>
