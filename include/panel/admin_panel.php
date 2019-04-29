<?php
//obtener últimos trabajos y clientes
require ('connect/panel/get_last_trabajos.php');
require ('connect/panel/get_last_clientes.php');
//obtener estadísticas del panel
require ('connect/panel/get_stats.php');
?>
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
                            <h4 class="page-title">Panel de Administración</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle shadow-lg bg-primary border-primary border">
                                        <i class="fe-users font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?= $numClientes?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">Clientes</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle shadow-lg bg-danger border-danger border">
                                        <i class="mdi mdi-account-key font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?= $numAdmins?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">Admins</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle shadow-lg bg-info border-info border">
                                        <i class="fe-bar-chart-line- font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?= $numTrabajos ?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">Trabajos</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->

                    <div class="col-md-6 col-xl-3">
                        <div class="widget-rounded-circle card-box">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded-circle shadow-lg bg-warning border-warning border">
                                        <i class="fe-shopping-bag font-22 avatar-title text-white"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-right">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup"><?= $numPaquetes ?></span></h3>
                                        <p class="text-muted mb-1 text-truncate">Paquetes</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div> <!-- end widget-rounded-circle-->
                    </div> <!-- end col-->
                </div>
                <!-- end row-->
                <div class="row">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-widgets">
                                    <a data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                    <a data-toggle="collapse" href="#lastTrabajosTable" role="button" aria-expanded="false" aria-controls="cardCollpase5"><i class="mdi mdi-minus"></i></a>
                                    <a data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                </div>
                                <h4 class="header-title mb-0">Últimas tareas añadidas</h4>
                                <div id="lastTrabajosTable" class="collapse pt-3 show">
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover table-centered m-0" >

                                    <thead class="thead-light">
                                    <tr>
                                        <th>Usuario</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        <th data-sortable="true">Data Inicio</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(isset($trabajos) && count($trabajos)){
                                        foreach($trabajos as $trabajo){ ?>
                                            <tr onClick="document.location.href='trabajos?cliente=<?= $trabajo['usuario']?>';" style="cursor:pointer;">

                                                <td>
                                                    <img width="30" src="scripts/TimThumb/mthumb.php?src=<?php echo "uploads/perfil/".$trabajo['perfil']; ?>&w=35&h=35&zc=2&q=95" alt="table-user" class="mr-2 rounded-circle">
                                                    <span><?= $trabajo['nom']?></span>
                                                </td>

                                                <td>
                                                    <span><?= strip_tags(substr($trabajo['descripcio'], 0, 30)).'...'?></span>
                                                </td>

                                                <td>
                                                    <?php if ($trabajo['estado']) { ?>
                                                        <a class="font-17"><span
                                                                    class="badge badge-danger">Completada</span></a> <?php  }

                                                    else{ ?>
                                                        <a class="font-17"><span class="badge badge-warning">Pendiente</span></a> <?php }
                                                    ?>
                                                </td>

                                                <td>
                                                    <span><?= date("d-m-Y", strtotime($trabajo['data_inici'])); ?></span>
                                                </td>

                                            </tr>
                                        <?php }} ?>
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div> <!-- end col -->


                </div>
                <!-- end row -->
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-widgets">
                                    <a data-toggle="reload"><i class="mdi mdi-refresh"></i></a>
                                    <a data-toggle="collapse" href="#lastClientesTable" role="button" aria-expanded="false" aria-controls="cardCollpase5"><i class="mdi mdi-minus"></i></a>
                                    <a data-toggle="remove"><i class="mdi mdi-close"></i></a>
                                </div>
                                <h4 class="header-title mb-0">Últimos clientes dados de alta</h4>
                                <div id="lastClientesTable" class="collapse pt-3 show">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-hover table-centered m-0">

                                            <thead class="thead-light">
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Data Alta</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            if(isset($ultimosClientes) && count($ultimosClientes)){
                                                foreach($ultimosClientes as $cliente){ ?>
                                                    <tr onClick="document.location.href='ficha?cliente=<?= $cliente['id']?>';" style="cursor:pointer;">

                                                        <td>
                                                            <img alt="table-user" class="mr-2 rounded-circle" width="30" src="scripts/TimThumb/mthumb.php?src=<?php echo "uploads/perfil/".$cliente['perfil']; ?>">
                                                            <span><?= $cliente['nom'] ?></span>
                                                        </td>

                                                        <td>
                                                            <span><?= $cliente['email'] ?></span>
                                                        </td>

                                                        <td>
                                                            <span><?= date("d-m-Y", strtotime($cliente['data_alta'])); ?></span>
                                                        </td>
                                                    </tr>
                                                <?php } }?>
                                            </tbody>
                                        </table>
                                    </div> <!-- end .table-responsive-->
                                </div>
                            </div>
                        </div> <!-- end col -->


                </div> <!-- container -->
        </div> <!-- content -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->
</div>
<!-- END wrapper -->
