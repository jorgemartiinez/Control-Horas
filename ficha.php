<?php
if(!isset($_SESSION)) {session_start(); }

//COMPROBAMOS QUE SEA CLIENTE Y QUE SI ES CLIENTE SOLO PUEDA ACCEDER A SUS TRABAJOS, ADEMÁS AL SER CLIENTE NO PUEDE HABER NINGÚN ID VISIBLE EN LA URL
if($_SESSION['usuario']['rol'] == 0) {
    $_GET['cliente'] = $_SESSION['usuario']['id'];

    if($_GET['cliente']!=$_SESSION['usuario']['id']){
        header("Location:".$GLOBALS['config']['rutaAbsoluta']);
    }
}else{
    //hacemos aquí el include si es admin porque desde panel.php ya se hacen los includes tanto para panel admin como panel cliente
    include('include/partials/main/header-main.php');
    include('include/partials/main/navbar-main.php');

    require('connect/clientes/checkCliente.php'); //devuelve los ids de la tabla users
//no queremos que se busque una ficha de un cliente que no existe, por lo que realizamos una comprobación
    if(!in_array($_GET['cliente'], $idsUsuariosExistentes)){header("Location:".$GLOBALS['config']['rutaAbsoluta']);}
}

require('connect/ficha/get_ficha.php'); //obtenemos los datos a mostrar en la página

?>

    <div id="wrapper" >
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <!-- Start Content-->
    <div class="content-page">
        <div class="content" >

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="panel">Panel</a></li>
                                    <li class="breadcrumb-item active">Ficha cliente</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Ficha Cliente</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">

                        <?php if(isset($horasData)){ ?>

                            <div class="card-box text-center">
                                <div class="user">
                                    <div class="user-img">
                                        <img src="scripts/TimThumb/mthumb.php?src=<?php echo "uploads/perfil/".$horasData['perfil']; ?>&w=100&h=100&zc=2&q=95" alt="user-img" title="<?= $horasData['nom'] ?>" width="80" class="rounded-circle img-fluid">
                                    </div>
                                </div>
                                <h4 class="mb-0"><?= $horasData['nom']; ?></h4>
                            </div>
                        <?php }else{
                            echo "  <div class=\"card-box text-center \"> 
                            <h3 class='text-warning text-center'> Este usuario todavía no tiene ningún paquete de horas contratado. </h3></div>";} ?>
                    </div>
                    <!-- end card-box -->
                </div>
            </div>
            <!-- end row-->
            <div class="row">
                <!-- end page title -->
                <div class="col-12">
                    <div class="card-box text-center" title="Saldo actual">
                        <div class="user">
                            <div class="avatar-lg rounded-circle shadow-lg bg-primary border-primary border" style=" display: block; margin: auto;">
                                <a><i class="fe-info font-22 avatar-title text-white "></i></a>
                            </div>
                            <h3 class="<?php if($saldo <=0){?>text-danger<?php }else{ ?> text-dark<?php }?> mt-2"><span data-plugin="counterup"><?= $saldo ?></span>h</h3>
                            <p class="text-muted mb-1 text-truncate">Saldo actual</p>
                        </div>
                        <!-- end widget-rounded-circle-->
                    </div>
                </div>
                <div class="col-6">
                    <div class="widget-rounded-circle card-box">
                        <div class="row" title="Total Horas Contratadas">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle shadow-lg bg-primary border-primary border">
                                    <i class="fe-bar-chart-line- font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <h3 class="text-dark mt-1"><span data-plugin="counterup"><?= $totalHorasContratadas ?></span>h</h3>
                                    <p class="text-muted mb-1 text-truncate">Total Horas Contratadas</p>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                    </div>
                    <!-- end widget-rounded-circle-->
                </div>

                <!-- end col-->
                <div class="col-6">
                    <div class="widget-rounded-circle card-box">
                        <div class="row" title="Total Horas Consumidas">
                            <div class="col-6">
                                <div class="avatar-lg rounded-circle shadow-lg bg-primary border-primary border">
                                    <i class="fe-bar-chart-line- font-22 avatar-title text-white"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text">
                                    <h3 class="text-dark mt-1"><span data-plugin="counterup"><?= $consumidas ?></span>h</h3>
                                    <p class="text-muted mb-1 text-truncate">Total horas Consumidas</p>
                                </div>
                            </div>
                        </div>
                        <!-- end row-->
                    </div>
                    <!-- end widget-rounded-circle-->
                </div>
                <!-- end col-->

                <?php if(isset($horasData) && $horasData  != null){ ?>
                    <div class="col-12">
                        <div class="widget-rounded-circle card-box text-center"
                        <div class="row">
                            <div class="text">
                                <?php if($horasData['fecha_caducidad']>date('Y-m-d H:i:s')){
                                    echo "<h3 class='text-success mt-1 '><span class='fe-check'></span><span>";
                                }else{
                                    echo "<h3 class='text-danger'><span class='fe-alert-circle'></span><span>";

                                } ?>
                                <?php echo $fecha_caducidad ?></span></h3>
                                <p class="text-muted">Fecha caducidad</p>
                                <?php
                                if($_SESSION['usuario']['rol'] == 1 ){
                                    if($horasData['fecha_caducidad']<date('Y-m-d H:i:s') && $saldo >0){?>
                                        <form id="form-caducar-horas" >
                                            <input type="hidden" id="titulo" value="Horas caducadas" required>
                                            <input type="hidden" id="horas"  value="<?= $saldoFormatoBD ?>" required >
                                            <input type="hidden" id="descripcion" value="Trabajo creado para agotar el saldo del usuario <?= $horasData['nom'] ?>.
                                            El trabajo aparecerá como completado y marcado con un 1 en su campo 'caducada' " required >
                                            <input type="hidden" id="cliente" value="<?= $_GET['cliente']?>">
                                            <button type="submit" class="btn btn-danger btn-rounded waves-effect waves-light">
                                                <span class="btn-label"><i class="mdi mdi-close-circle-outline"></i></span>Caducar Horas
                                            </button>
                                        </form>
                                    <?php }}?>
                            </div>
                        </div>
                    </div>
                    <!-- end row-->
                <?php }?>
                <!-- end widget-rounded-circle-->
            </div>
        </div>
        <!-- end col-->
    </div>
    <!-- container -->

    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    <!-- END wrapper -->


    <!-- Validación formularios -->
    <script src="js/validaciones/form-validation.js" type="text/javascript"></script>

    <!-- Operaciones ficha -->
    <script src="js/ficha/ficha.js" type="text/javascript"></script>


<?php if($_SESSION['usuario']['rol'] == 1) {include('include/partials/main/footer-main.php');}?>