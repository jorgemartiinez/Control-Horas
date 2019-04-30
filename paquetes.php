<?php
include('include/partials/main/header-main.php');
include('include/partials/main/navbar-main.php');

//COMPROBAMOS QUE SEA CLIENTE Y QUE SI ES CLIENTE SOLO ESTÉ ACCEDIENDO A SUS PAQUETES
if($_SESSION['usuario']['rol'] == 0) {

    $_GET['cliente'] = $_SESSION['usuario']['id'];

    if($_GET['cliente']!=$_SESSION['usuario']['id']){
        header("Location:".$GLOBALS['config']['rutaAbsoluta']);
    }
}else{
    require('connect/clientes/checkCliente.php'); //devuelve los ids de la tabla users
//no queremos que se busque una ficha de un cliente que no existe, por lo que realizamos una comprobación
    if(!in_array($_GET['cliente'], $idsUsuariosExistentes)){header("Location:".$GLOBALS['config']['rutaAbsoluta']);}
}

//OBTENEMOS LOS PAQUETES POR CLIENTE
require('connect/paquetes/getPaquetesByCliente.php');

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
                                    <li class="breadcrumb-item"><a >CRM</a></li>
                                    <li class="breadcrumb-item active">Packs</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Packs</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <h4 class="header-title">Gestión de Packs Horas </h4>

                        <?php if($_SESSION['usuario']['rol'] == 0){ ?>
                            <p class="sub-header mb-2 info">
                                Desde esta página podrá consultar su historial de paquetes comprados.
                            </p>
                        <?php }else{ ?>
                            <p class="sub-header mb-2 info">
                                Desde esta página podrá consultar los paquetes del cliente en cuestión. Las operaciones disponibles son: añadir y borrar.
                            </p>
                        <?php }?>
                        <?php if($_SESSION['usuario']['rol'] == 1){ ?>
                            <div class="row mb-2">
                                <div class="col-sm-4">
                                    <a href="#nuevo-paquete-modal" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"><i class="mdi mdi-plus-circle mr-1"></i> Nuevo Paquete</a>
                                </div>
                            </div>
                        <?php } ?>
                        <table id="tabla-paquetes" data-toggle="table"
                               data-search="true"
                               data-show-refresh="false"
                               data-sort-name="id"
                               data-page-list="[5, 10, 20]"
                               data-page-size="5"
                               data-pagination="true" data-show-pagination-switch="true" class="table-borderless">
                            <thead class="thead-light">
                            <tr>
                                <th data-field="ID" data-sortable="false">#</th>
                                <th data-field="Horas" data-sortable="false">Horas</th>
                                <th data-field="Fecha Inicio" data-sortable="true" data-formatter="dateFormatter">Data Inicio</th>
                                <th data-field="Fecha Alta" data-sortable="true" data-formatter="dateFormatter">Data Final</th>
                                <?php if($_SESSION['usuario']['rol']==1){ ?> <th data-field="Acciones" >Acciones</th> <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($paquetes) && count($paquetes)){
                                $count = 0;
                                foreach($paquetes as $paquete ){ ?>
                                    <tr>
                                    <td>
                                        <?=$count+=1?>
                                    </td>
                                    <td>
                                        <?=$paquete['horas']?>
                                    </td>
                                    <td>
                                        <?=date("d-m-Y", strtotime($paquete['data_inici']));?>
                                    </td>
                                    <td>
                                        <?=date("d-m-Y", strtotime($paquete['data_final']));?>
                                    </td>

                                    <?php if($_SESSION['usuario']['rol'] == 1){ ?>
                                        <td>
                                            <a onclick='delPaquete(<?= $paquete['id'] ?>)' class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                        </td>
                                        </tr>
                                    <?php }
                                }
                            } ?>
                            </tbody>
                        </table>
                    </div> <!-- end card-box-->
                </div> <!-- end col-->
            </div>
            <!-- end row-->
        </div> <!-- container -->
    </div> <!-- content -->

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
                    <input type="hidden" id="cliente" value="<?php echo $_GET['cliente']?>">
                    <button type="submit" class="btn btn-primary ">Enviar</button>
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
