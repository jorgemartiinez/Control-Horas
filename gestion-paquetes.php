<?php
include('include/partials/main/header-main.php');
include('include/partials/main/navbar-main.php');

//si no eres admin, redirect
if($_SESSION['usuario']['rol']!=1){header("Location:".$GLOBALS['config']['rutaAbsoluta']);}

//llamada para obtener todos los paquetes
require('connect/paquetes/get_paquetes.php');

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
                                    <li class="breadcrumb-item"><a>CRM</a></li>
                                    <li class="breadcrumb-item active">Packs</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Packs</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
            </div>
            <div class="col-sm-4">
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <h4 class="header-title">Gestión de Packs Horas </h4>
                        <p class="sub-header mb-2 info">
                            Desde esta página podrá gestionar los paquetes añadidos de su base de datos. Podrá borrarlos y añadir uno nuevo para el usuario en cuestión desde aquí.
                        </p>

                        <table id="tabla-paquetes" data-toggle="table"
                               data-search="true"
                               data-show-refresh="false"
                               data-sort-name="id"
                               data-page-list="[5, 10, 20]"
                               data-page-size="5"
                               data-pagination="true" data-show-pagination-switch="true" class="table-borderless">
                            <thead class="thead-light">
                            <tr>
                                <th data-field="Nombre" data-sortable="false">Name</th>
                                <th data-field="Rol" data-sortable="false">Horas</th>
                                <th data-field="Fecha Inicio" data-sortable="true" data-formatter="dateFormatter">Data Inicio</th>
                                <th data-field="Fecha Alta" data-sortable="true" data-formatter="dateFormatter">Data Final</th>
                                <th data-field="Acciones" >Acciones</th>
                            </tr>
                            </thead>

                            <tbody>

                            <?php
                            if(isset($paquetes)&&count($paquetes)){
                                foreach($paquetes as $paquete ){ ?>
                                    <tr>
                                        <td>
                                            <img width="30" src="scripts/TimThumb/mthumb.php?src=<?php echo "uploads/perfil/".$paquete['perfil']; ?>&w=35&h=35&zc=2&q=95" alt="table-user" class="mr-2 rounded-circle">
                                            <?=$paquete['nom']?>
                                        </td>
                                        <td>
                                            <?=$paquete['horas']?>
                                        </td>
                                        <td>
                                            <?=$paquete['data_inici']?>
                                        </td>
                                        <td>
                                            <?=$paquete['data_final']?>
                                        </td>
                                        <td>
                                            <a onclick="abrirModal(<?=$paquete['cliente']?>)" class="action-icon" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"><i class="mdi mdi-plus-circle mr-1"></i> </a>
                                            <a onclick='delPaquete(<?= $paquete['id'] ?>)' class="action-icon" title="Borrar paquete de <?=$paquete['nom']?>"> <i class="mdi mdi-delete"></i></a>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>
                            </tbody>
                        </table>
                    </div> <!-- end card-box-->
                </div> <!-- end col-->
            </div>
            <!-- end row-->
        </div> <!-- container -->

    </div> <!-- content -->
    <a href="#nuevo-paquete-modal" class="btn btn-danger waves-effect waves-light invisible" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="abrir-nuevo-paquete"> </a>

    <!-- Modal nuevo paquete-->
    <div id="nuevo-paquete-modal" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.modal.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Formulario nuevo paquete</h4>
        <div class="custom-modal-text text-left">
            <form id="form-enviar-paquete">
                <div class="form-group">
                    <label for="horas">Duración paquete en horas</label>
                    <input type="number" class="form-control" id="horas" min="1" step="1" required placeholder="Introduzca una duración en horas." onkeyup="comprobarCampo(this)" autofocus>
                    <small id="tituloHelp" class="form-text text-muted">Duración del paquete en horas (NÚMERO ENTERO). Se le sumarán al saldo existente del usuario y la fecha final pasará a ser la de este último.</small>
                </div>
                <div class="form-group">
                    <label for="meses">Meses antes de caducar</label>
                    <input type="number" class="form-control" id="meses" min="1" value="18" step="1" required placeholder="Introduzca los meses que durará el paquete..." onkeyup="comprobarCampo(this)">
                    <small id="tituloHelp" class="form-text text-muted">Tiempo en meses hasta que caduque el paquete.</small>
                </div>
                <input type="hidden" id="cliente" >
                <button type="submit" class="btn btn-primary">Enviar</button>
            </form>
        </div>
    </div>
    <!-- Scripts -->
    <!-- Operaciones con paquetes -->
    <script src="js/paquetes/paquetes.js" type="text/javascript"></script>
    <!-- Validación formularios -->
    <script src="js/validaciones/form-validation.js" type="text/javascript"></script>
    <!-- Nuevo paquete -->
    <script src="js/paquetes/nuevo_paquete.js" type="text/javascript"></script>
<?php include('include/partials/main/footer-main.php');?>