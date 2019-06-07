<?php
include('include/partials/main/header-main.php');
include('include/partials/main/navbar-main.php');

//comprobamos que el usuario sea admin
if($_SESSION['usuario']['rol']!=1){header("Location:".$GLOBALS['config']['rutaAbsoluta']);}

//si no recibimos un parámetro de rol válido para poder validar los usuarios
if(!isset($_GET['rol']) || !is_numeric($_GET['rol'])||$_GET['rol'] > 1){header("Location:".$GLOBALS['config']['rutaAbsoluta'].'/usuarios?rol=0');}
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
                                    <li class="breadcrumb-item"><a href="panel">Panel </a></li>
                                    <li class="breadcrumb-item"><a>CRM</a></li>
                                    <li class="breadcrumb-item active"><?php echo ($_GET['rol']) ? "Administradores" : "Clientes" ?></li>
                                </ol>
                            </div>
                            <h4 class="page-title"><?php echo ($_GET['rol']) ? "Administradores" : "Clientes" ?></h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <h4 class="header-title">Gestión de  <?php echo ($_GET['rol']) ? "administradores" : "clientes" ?>
                        </h4>
                        <p class="sub-header mb-2 info">
                            Desde esta página podrá gestionar los usuarios de su base de datos. Las operaciones disponibles son crear, editar y activar/suspender cuenta.
                        </p>

                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <a href="#anyadir-cliente-modal" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"><i class="mdi mdi-plus-circle mr-1"></i> Añadir <?php echo ($_GET['rol']) ? "Admin" : "Cliente" ?></a>
                            </div>

                            <!-- end col-->
                        </div>
                        <table id="tabla-clientes" data-toggle="table"
                               data-search="true"
                               data-show-refresh="false"
                               data-sort-name="id"
                               data-page-list="[5, 10, 20]"
                               data-page-size="5"
                               data-pagination="true" data-show-pagination-switch="true" class="table-borderless">
                            <thead class="thead-light">
                            <tr>
                                <th data-field="Nombre" data-sortable="false">Name</th>
                                <th data-field="Email" data-sortable="false">Email</th>
                                <th data-field="Fecha Alta" data-sortable="true" data-formatter="dateFormatter">Fecha Alta</th>
                                <th data-field="Estado" data-align="center" data-sortable="true" >Estado</th>
                                <th data-field="Acciones" >Acciones</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php
                            if(isset($resultados) && count($resultados)){
                                foreach($resultados as $cliente ){
                                    if($cliente['rol'] == $_GET['rol']){ ?>
                                        <tr>
                                            <td class="table-user">
                                                <img src="scripts/TimThumb/mthumb.php?src=<?php echo "uploads/perfil/".$cliente['perfil']; ?>&w=35&h=35&zc=2&q=95" alt="table-user" class="mr-2 rounded-circle">
                                                <a class="user-edit" title='Editar Foto Perfil Cliente' href="javascript:abrirArchivos('<?=$cliente['id']?>')" ><i class="mdi mdi-pencil"></i></a>
                                                <a class="text-body font-weight-semibold"><?=$cliente['nom']?></a>
                                            </td>

                                            <td>
                                                <?=$cliente['email']?>
                                            </td>
                                            <td>
                                                <?=$cliente['data_alta']?>
                                            </td>
                                            <td>
                                                <?php echo (($cliente['estado'])?'<span class="badge badge-success">Activa</span>'
                                                    :' <span class="badge badge-danger">Suspendida</span>')?>
                                            </td>

                                                <td>
                                                    <a data-animation="fadein" data-plugin="custommodal" class="action-icon" title='Editar usuario' onclick='editarCliente(<?= $cliente['id'] ?>)' >  <i class="mdi mdi-account-edit"></i></a>

                                                    <?php echo (($cliente['estado'])?'<a data-animation="\fadein\" data-plugin="\custommodal\" onclick="cambiarEstado('.$cliente['id'] . ', ' .$cliente['estado']  . ') " class="action-icon" title=\'Cambiar estado\'> <i class="mdi mdi-account-off"></i></a>'
                                                        :'<a data-animation="fadein" onclick="cambiarEstado('.$cliente['id'] . ', ' .$cliente['estado']  . ') " class="action-icon" title=\'Cambiar estado\'> <i class="mdi mdi-account-check" ></i></a>') ?>
                                                    <a onclick='deleteCliente(<?= $cliente['id'] ?>)' class="action-icon" title="Eliminar usuario"> <i class="mdi mdi-delete"></i></a>
                                                </td>

                                        </tr>
                                    <?php }} }?>
                            </tbody>
                        </table>
                    </div> <!-- end card-box-->
                </div> <!-- end col-->
            </div>
            <!-- end row-->
        </div> <!-- container -->
    </div> <!-- content -->


    <!-- MODALES -->
    <!-- Modal añadir cliente-->
    <div id="anyadir-cliente-modal" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.modal.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Añadir usuario</h4>
        <div class="custom-modal-text text-left">
            <form id="anyadir-cliente">
                <div class="form-group">
                    <label for="nombre-nuevo">Nombre</label>
                    <input type="text" class="form-control" id="nombre-nuevo" name="nombre" placeholder="Nombre usuario" onkeyup="comprobarCampo(this)" required>
                </div>
                <div class="form-group">
                    <label for="email-nuevo">Email</label>
                    <input type="email" class="form-control" id="email-nuevo" placeholder="Email" onkeyup="comprobarCampo(this)" required>
                </div>

                <div class="form-group">
                    <label for="rol-nuevo">Rol</label>

                    <?php if($_GET['rol'] == 1){ ?>
                        <select id="rol-nuevo" class="form-control" required disabled>
                            <option value="1" selected>Administrador</option>
                            <option value="0">Usuario</option>
                        </select>
                    <?php }else{ ?>
                        <select id="rol-nuevo" class="form-control" required disabled>
                            <option value="1">Administrador</option>
                            <option value="0" selected>Usuario</option>
                        </select>
                    <?php } ?>

                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-success waves-effect waves-light">Añadir</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" id="cancelar-form-nuevo-cliente">Cancelar</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal editar cliente-->
    <div id="editar-cliente-modal" class="modal-demo">
        <button type="button" class="close" onclick="Custombox.modal.close();">
            <span>&times;</span><span class="sr-only">Close</span>
        </button>
        <h4 class="custom-modal-title">Editar usuario</h4>
        <div class="custom-modal-text text-left">
            <form id="form-editar-cliente">
                <input type="hidden" class="form-control" id="id-cliente-editar" required>

                <div class="form-group">
                    <label for="nombre-editar">Nombre</label>
                    <input type="text" class="form-control" id="nombre-editar" name="nombre-editar" placeholder="Nombre usuario" onkeyup="comprobarCampo(this)" required>
                </div>
                <div class="form-group">
                    <label for="email-editar">Email</label>
                    <input type="email" class="form-control" id="email-editar" placeholder="Email" onkeyup="comprobarCampo(this)" required>
                </div>

                <div class="form-group">

                    <?php if($_GET['rol'] == 1){ ?>
                        <label for="rol-editar">Rol</label>
                        <select id="rol-editar" class="form-control" required>
                            <option value="1" selected>Administrador</option>
                            <option value="0">Usuario</option>
                        </select>
                    <?php }else{ ?>
                        <label for="rol-editar">Rol</label>
                        <select id="rol-editar" class="form-control" required>
                            <option value="1">Administrador</option>
                            <option value="0" selected>Usuario</option>
                        </select>
                    <?php } ?>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-success waves-effect waves-light">Editar</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" id="cancelar-form-editar-cliente">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

</div>

<a href="#editar-cliente-modal" class="btn btn-danger waves-effect waves-light invisible" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="obrir_editar_client"> </a>
<input id="subir-foto-perfil" class="invisible" type="file" accept=".jpg, .jpeg, .png">

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->

<!-- END wrapper -->


<!-- Scripts -->
<!-- Validación formularios -->
<script src="js/validaciones/form-validation.js" type="text/javascript"></script>

<!-- Realizar operaciones clientes -->
<script src="js/clientes/clientes.js" type="text/javascript"></script>

<?php include('include/partials/main/footer-main.php');?>

