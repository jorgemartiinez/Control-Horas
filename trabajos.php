<?php
include('include/partials/main/header-main.php');
include('include/partials/main/navbar-main.php');

//COMPROBAMOS QUE SEA CLIENTE Y QUE SI ES CLIENTE SOLO PUEDA ACCEDER A SUS TRABAJOS, ADEMÁS AL SER CLIENTE NO PUEDE HABER NINGÚN ID VISIBLE EN LA URL

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

//obtenemos los trabajos
require('connect/trabajos/get_trabajosByCliente.php');


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
                                    <li class="breadcrumb-item"><a >Gestión</a></li>
                                    <li class="breadcrumb-item active">Trabajos</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Gestión trabajos</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
            </div>

            <div class="row">
                <div class="col-sm-12">

                    <div class="card-box">
                        <h4 class="header-title">Trabajos</h4>

                        <?php if($_SESSION['usuario']['rol'] == 1){ ?>
                            <p class="sub-header mb-2 info">
                                Desde esta página podrá gestionar los trabajos de cada usuario. Las acciones disponibles son; ver la descripción completa, editar la tarea o borrarla.
                            </p>
                        <?php }else{ ?>
                            <p class="sub-header mb-2 info">
                                Desde esta página podrá ver los trabajos que han sido creados para usted y comprobar el estado de los mismos.
                                Si hace click en el título, podrá ver la descripción del mismo.
                            </p>
                        <?php }?>


                        <?php if($_SESSION['usuario']['rol'] == 1){ ?>
                            <div class="row mb-2">
                                <div class="col-sm-4">
                                    <a href='nuevo-trabajo?cliente=<?= $_GET['cliente']?>' class="btn btn-danger waves-effect waves-light"  data-overlaycolor="#38414a"><i class="mdi mdi-plus-circle mr-1"></i> Añadir Trabajo</a>
                                </div>
                            </div>
                        <?php } ?>

                        <table id="tabla-clientes" data-toggle="table"
                               data-search="true"
                               data-show-refresh="false"
                               data-sort-name="id"
                               data-page-list="[10, 15, 20]"
                               data-page-size="10"
                               data-pagination="true" data-show-pagination-switch="true" class="table-borderless">
                            <thead class="thead-light">
                            <tr>
                                <th data-field="Titulo" data-sortable="false">Titulo</th>
                                <th data-field="Fecha Inicio" data-sortable="true" data-formatter="dateFormatter">Fecha Inicio</th>
                                <th data-field="Fecha Final" data-sortable="true" data-formatter="dateFormatter">Fecha Final</th>
                                <th data-field="Horas" data-sortable="false">Horas</th>
                                <th data-field="Estado" data-sortable="true">Estado</th>
                                <?php if($_SESSION['usuario']['rol']){ ?> <th data-field="Acciones" >Acciones</th> <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if(isset($trabajos)&&count($trabajos)){
                                foreach($trabajos as $trabajo ){
                                    if($_SESSION['usuario']['rol'] == 1 && $trabajo['caducada'] == 0
                                        || $_SESSION['usuario']['rol'] == 1 && $trabajo['caducada'] == 1
                                        || $_SESSION['usuario']['rol'] == 0 && $trabajo['caducada'] == 0){
                                        ?>
                                        <tr >
                                            <td>
                                                <a class="action-icon text-primary" onclick="showDescripcion('<?=$trabajo['id']?>')" title='Ver Descripción' style="font-size:14px"> <?= $trabajo['titulo']?></a>
                                            </td>
                                            <td><?=date("d-m-Y", strtotime($trabajo['data_inici'])); ?>

                                            <td>
                                                <?php

                                                if($trabajo['data_final']!='0000-00-00 00:00:00' ) {
                                                    echo date("d-m-Y", strtotime($trabajo['data_final']));
                                                }
                                                ?>

                                            </td>
                                            <td><?= $trabajo['hores'] ?>
                                            </td>

                                            <?php if($_SESSION['usuario']['rol'] == 1){ ?>
                                                <td>

                                                    <?php if($trabajo['caducada'] != 1) { ?>

                                                        <?php if ($trabajo['estado']) { ?>
                                                            <a <!--class="action-icon"
                                                           onclick="updateEstado(<?= $trabajo['id'] ?>, 1)" --><span
                                                                    class="badge badge-danger font-13">Completada</span></a> <?php  }

                                                        else{ ?>
                                                            <a <!--class="action-icon" onclick="updateEstado(<?=$trabajo['id']?>, 0)"--> <span class="badge badge-warning font-13">Pendiente</span></a> <?php }
                                                        ?>
                                                    <?php }else{ ?>

                                                        <a class="action-icon" style="cursor: default"><span class="badge badge-info font-13">Caducada</span></a>
                                                    <?php } ?>
                                                </td>

                                            <?php }else{ ?>
                                                <td>
                                                    <?php if($trabajo['estado']){ ?>
                                                        <a><span class="badge badge-danger font-13">Completada</span></a>
                                                    <?php } else{ ?>
                                                        <a ><span class="badge badge-warning font-13">Pendiente</span></a>
                                                    <?php } ?>
                                                </td>
                                            <?php } ?>

                                            <?php if($_SESSION['usuario']['rol'] == 1){ ?>
                                                <td>

                                                    <a class="action-icon" <?php if($trabajo['estado'] == 1){ ?>title='Trabajo ya completado.' onclick="mensajeCustomUnBotonSinRecargar('Información trabajo', 'El trabajo que está intentando editar ya está completado.', 'info')" <?php }else{ ?> title="Editar trabajo" href="editar-trabajo?trabajo=<?=$trabajo['id']?>&cliente=<?=$trabajo ['id_client']?>" <?php }?>><i class="mdi mdi-lead-pencil"></i></a>
                                                    <a class="action-icon" onclick="deleteTrabajo('<?=$trabajo['id']?>', '<?=$trabajo['titulo']?>' )" title='Borrar trabajo'><i class="mdi mdi-delete"></i></a>
                                                </td>
                                            <?php } ?>
                                        </tr>
                                    <?php  }}
                            } ?>
                            </tbody>
                        </table>
                    </div> <!-- end card-box-->
                </div> <!-- end col-->
            </div>
            <!-- end row-->
        </div> <!-- container -->

    </div> <!-- content -->


    <a href="#show-descripcion-modal" class="btn btn-danger waves-effect waves-light invisible" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="abrir_modal_descripcion"> </a>

    <div class='modal-demo' id='show-descripcion-modal'  >
        <button type='button' class='close' onclick='Custombox.modal.close();'>
            <span>&times;</span><span class='sr-only'>Close</span>
        </button>
        <h4 class="custom-modal-title" id="show-titulo-text">Título trabajo</h4>
        <div class='custom-modal-text text-left' >
            <span><strong>Descripción: </strong> <p id="show-descripcion-text"></p></span>
            <span><strong>Creado el </strong> <p id="show-fecha-text"></p></span>
        </div>
        <div class="text-right">
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" id="close-show-descripcion">Salir</button>
        </div>
    </div>

    <!-- Scripts -->
    <!-- Validación formularios -->
    <script src="js/validaciones/form-validation.js" type="text/javascript"></script>
    <!-- Mostrar descripción -->
    <script src="js/trabajos/show_descripcion.js" type="text/javascript"></script>
    <!-- Operaciones con trabajos -->
    <script src="js/trabajos/trabajos.js" type="text/javascript"></script>

    <?php include('include/partials/main/footer-main.php');?>

