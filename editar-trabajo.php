<?php
include('include/partials/main/header-main.php');
include('include/partials/main/navbar-main.php');

//SÓLO PUEDE ACCEDER EL ADMIN
if($_SESSION['usuario']['rol']!=1){header("Location:".$GLOBALS['config']['rutaAbsoluta']);}

if($_SESSION['usuario']['rol'] == 1) {
    require('connect/trabajos/checkTrabajo.php'); //devuelve mayor a 0 si ese cliente tiene ese trabajo en concreto
//no queremos que se introduzca una id de un trabajo que no tiene un cliente, por lo que realizamos una comprobación
    if($existeTrabajoYCliente['countTrabajoCliente']<=0){header("Location:".$GLOBALS['config']['rutaAbsoluta']);}
}

//Obtenemos el trabajo
require('connect/trabajos/get_trabajo.php');

//comprobamos que el trabajo exista
if(count($trabajo) == 0){header("Location:/v2/panel");}

?>
<!-- Begin page -->
<div id="wrapper">
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="panel">Panel</a></li>
                                    <li class="breadcrumb-item"><a>Clientes</a></li>
                                    <li class="breadcrumb-item active">Editar Trabajo</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Editar trabajo</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mb-3 header-title">Editar trabajo</h4>
                                <p class="sub-header mb-2 info">
                                    Desde esta página podrá editar sus trabajos. Si pulsa en <strong>'Editar'</strong> se actualizarán todos los datos del trabajo a excepción de las horas y el trabajo seguirá como <strong>pendiente</strong>, en cambio, si pulsa en <strong>'Editar y completar'</strong>
                                    se actualizarán todos los datos, el trabajo pasará a estar <strong>completado</strong> y se enviará un correo para notificar al cliente.
                                </p>
                                <form id="form-editar-trabajo">
                                    <div class="form-group">
                                        <label for="titulo">Título</label>
                                        <input type="text" class="form-control" id="titulo" value="<?php echo ($trabajo['titulo'] != '0') ? $trabajo['titulo'] : substr($trabajo['descripcio'], 0 ,20)?>" aria-describedby="emailHelp" placeholder="Introduzca un título para la tarea." onkeyup="comprobarCampo(this)" required>
                                        <small id="tituloHelp" class="form-text text-muted">Se usará para ayudar a describir la tarea.</small>
                                    </div>

                                    <input type="hidden" id="cliente" value="<?php echo $_GET['cliente']?>">
                                    <input type="hidden" id="trabajo" value="<?php echo $_GET['trabajo']?>">

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <label for="horas">Duración tarea horas</label>
                                                <input type="number" min="0" step="1" class="form-control" id="horas" value="<?=$horas ?>" required onkeyup="comprobarCampo(this)" placeholder="Introduzca las horas que durará su tarea.">
                                                <small id="tituloHelp" class="form-text text-muted">Duración en horas de la tarea. </small>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label for="minutos">Duración minutos</label>
                                                <input type="number" min="0" step="15" max="45" class="form-control" id="minutos" value="<?=$minutos ?>" required onkeyup="comprobarCampo(this)" placeholder="Introduzca los minutos que durará su tarea.">
                                                <small id="tituloHelp" class="form-text text-muted">Duración en minutos de la tarea.</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="summernote-editor">Descripción</label>
                                        <!-- Inicio summernote -->

                                        <textarea id="summernote-editor" ><?php echo $trabajo['descripcio']?></textarea>
                                        <!-- end summernote-editor-->
                                    </div>

                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Editar</button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light" id="editar-completar">Editar y completar tarea</button>
                                </form>
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div>
                    <div class="col-12 text-center mb-2">
                        <button class="btn btn-success waves-effect waves-light" onClick="history.go(-1)">Volver</button>
                    </div>
                    <!-- end col -->
                </div> <!-- container -->
            </div> <!-- content -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
    </div>
    <!-- END wrapper -->

    <!-- Scripts -->
    <!-- Validación formularios -->
    <script src="js/validaciones/form-validation.js" type="text/javascript"></script>
    <!-- Editar trabajo -->
    <script src="js/trabajos/editar_trabajo.js" type="text/javascript"></script>

    <?php include('include/partials/main/footer-main.php');?>
