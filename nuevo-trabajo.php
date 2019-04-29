<?php
include('include/partials/main/header-main.php');
include('include/partials/main/navbar-main.php');
//si no es un admin, redirect
if($_SESSION['usuario']['rol']!=1){header("Location:".$GLOBALS['config']['rutaAbsoluta']);}
if($_SESSION['usuario']['rol'] == 1) {
    require('connect/clientes/checkCliente.php'); //devuelve los ids de la tabla users
//no queremos que se busque una ficha de un cliente que no existe, por lo que realizamos una comprobación
    if(!in_array($_GET['cliente'], $idsUsuariosExistentes)){header("Location:".$GLOBALS['config']['rutaAbsoluta']);}
}
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
                                    <li class="breadcrumb-item active">Nuevo Trabajo</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Añadir nuevo trabajo</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mb-1 header-title">Nuevo trabajo</h4>
                                <p class="sub-header mb-2 info">
                                    Desde esta página podrá añadir sus trabajos. En primera instancia, deberá de añadir título y descripción.
                                </p>
                                <form id="form-enviar-trabajo">
                                    <div class="form-group">
                                        <label for="titulo">Título</label>
                                        <input type="text" class="form-control" id="titulo" aria-describedby="emailHelp" placeholder="Introduzca un título para la tarea." onkeyup="comprobarCampo(this)" autofocus required>
                                        <small id="tituloHelp" class="form-text text-muted">Se usará para ayudar a describir la tarea.</small>
                                    </div>

                                    <input type="hidden" id="cliente" value="<?php echo $_GET['cliente']?>">
                                    <div class="form-group">
                                        <label for="summernote-editor">Descripción</label>
                                        <!-- Inicio summernote -->
                                        <textarea id="summernote-editor"></textarea>
                                        <!-- end summernote-editor-->
                                    </div>
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Enviar</button>
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
    <!-- Nuevo trabajo -->
    <script src="js/trabajos/nuevo_trabajo.js" type="text/javascript"></script>

    <?php include('include/partials/main/footer-main.php');?>
