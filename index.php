<?php include('include/partials/login/header-login.php'); ?>

<div class="account-pages mt-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card ">
                    <div class="card-body p-4">

                        <div class="text-center" style="background-color: #566676;  border-radius: 6px; padding-top: 20px;">
                            <?php if(isset($_SESSION['config'])&&$_SESSION['config']!=null && $_SESSION['config']['logo'] != ''){ ?>
                            <span class="text-center"><img src="<?='uploads/logo/'.$_SESSION['config']['logo']?>" alt="logo <?=$_SESSION['config']['footer-empresa']?>" height="50"></span>
                            <?php } ?>
                            <p class="text-white mt-2 mb-3"> Control de <strong> horas de trabajo </strong> <br/><br/> </p>
                        </div>

                        <!-- Alerta cuando haya expirado la sesión -->
                        <?php if(!isset($_SESSION)) {session_start();}
                        if(isset($_SESSION['expired']) && $_SESSION['expired'] == 1 && isset($_SESSION['expiredMail'])){ ?>
                        <p class="text-danger text-center mb-4 mt-3 font-16">
                            <i class="fe-alert-circle font-20"></i><strong>&nbsp;¡Tu sesión ha expirado por inactividad!</strong>
                        </p>
                        <?php }?>
                        <!-- Fin alerta -->

                        <form id="form-login">
                            <div class="form-group mb-3">
                                <label for="emailaddress">Email</label>
                                <input class="form-control" type="email" id="email" required="" placeholder="Introducir email" onkeyup="comprobarCampo(this)" autofocus <?php if(isset($_SESSION['expired']) && $_SESSION['expired'] == 1){echo "value='".$_SESSION['expiredMail']."'"; session_destroy();} ?> >
                            </div>

                            <div class="form-group ">
                                <label for="password">Contraseña</label>
                                <input class="form-control" type="password" required="" id="password" placeholder="Introducir contraseña" onkeyup="comprobarCampo(this)">
                            </div>

                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="mostrarContrasenya">
                                <label class="custom-control-label" for="mostrarContrasenya">Mostrar contraseña</label>
                            </div>

                            <div class="form-group mb-2 text-center">
                                <button class="btn btn-primary btn-block" type="submit"> Iniciar sesión </button>
                            </div>
                        </form>
                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->
                <div class="row text-center">
                    <div class="col-12">
                        <p> <a href="recuperar-password" class="text-white ml-1">¿Has olvidado tu contraseña?</a></p>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>


<!-- Validar y crear sesión en login -->
<script src="js/login/login.js" type="text/javascript"></script>

<?php include('include/partials/login/footer-login.php'); ?>
