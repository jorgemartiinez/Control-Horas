<?php
include('include/partials/main/header-main.php');
include('include/partials/main/navbar-main.php');
?>
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    <div id="wrapper">
    <div class="content-page" >
        <div class="content" >
            <!-- Start Content-->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="panel">Panel</a></li>
                                    <li class="breadcrumb-item active">Perfil</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Perfil</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="card-box text-center ">
                    <div class="user">
                        <div class="user-img mt-4">
                            <img src="scripts/TimThumb/mthumb.php?src=<?php echo "uploads/perfil/".$_SESSION['usuario']['perfil']; ?>&w=80&h=80&zc=2&q=95" alt="Foto de perfil" width="80" class="rounded-circle img-fluid ">
                            <a style="position:absolute" href="javascript:abrirArchivos()" class="user-edit" title='Editar Foto Perfil'><i class="mdi mdi-pencil font-20"></i></a>
                        </div>
                    </div>
                    <h4 class="mb-0"><?php echo $_SESSION['usuario']['nom']?></h4>
                    <h6><small class="text-info">Se recomienda subir las imágenes en jpg/jpeg. </small></h6>

                    <div class="text-center mt-3 mb-5">

                        <p class="text-muted mb-2 font-13"><strong>Nombre :</strong> <span class="ml-2"><?php echo $_SESSION['usuario']['nom']?></span></p>

                        <p class="text-muted mb-2 font-13 mb-3"><strong>Email :</strong> <span class="ml-2 "><?php echo $_SESSION['usuario']['email']?></span></p>

                        <a href="#editar-info-modal" class="btn btn-info btn-rounded waves-effect waves-light mt-3 mb-3" data-animation="fadein" data-plugin="custommodal"  data-overlaycolor="#38414a" >
                            <span class="btn-label"><i class="mdi mdi-circle-edit-outline"></i></span>Cambiar datos usuario
                        </a>
                             </br></br>
                        <a href="#editar-contrasenya-modal" class="btn btn-danger btn-rounded waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" >
                            <span class="btn-label"><i class="mdi mdi-account-key"></i></span>Cambiar contraseña
                        </a>

                    </div>

                </div> <!-- end card-box -->
                <div class="col-12 text-center mb-4">
                    <button class="btn btn-success waves-effect waves-light" onClick="history.go(-1)">Volver</button>
                </div>
            </div> <!-- end container -->

            <!-- end wrapper -->

            <!-- Modal -->
            <div id="editar-info-modal" class="modal-demo">
                <button type="button" class="close" onclick="Custombox.modal.close();" >
                    <span>&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="custom-modal-title bg-info">Editar información personal</h4>
                <div class="custom-modal-text text-left">
                    <form id="editar-perfil">
                        <div class="form-group">
                            <label for="nombre-nuevo">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre usuario" maxlength="60" value="<?php echo $_SESSION['usuario']['nom']?>" onkeyup="comprobarCampo(this)" required>
                        </div>
                        <div class="form-group">
                            <label for="email-nuevo">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Email" value="<?php echo $_SESSION['usuario']['email']?>" onkeyup="comprobarCampo(this)" maxlength="100" required>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Editar</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- Modal -->
            <div id="editar-contrasenya-modal" class="modal-demo">
                <button type="button" class="close" onclick="Custombox.modal.close();" >
                    <span>&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="custom-modal-title bg-danger">Restablecer contraseña</h4>
                <div class="custom-modal-text text-left">
                    <p class="text-info">Vamos a proceder a cambiar tu contraseña actual. Deberá de contener un mínimo de 6 carácteres, con minúsculas, mayúsculas y algún número.</p>
                    <div id="errores" >
                    </div>
                    <form id="editar-pass">
                        <div class="form-group">
                            <label for="password-actual">Contraseña actual</label>
                            <input type="password" class="form-control" id="password-actual" name="password-actual" placeholder="Introduzca su contraseña actual." required>
                        </div>
                        <div class="form-group">
                            <label for="password-actual">Nueva contraseña</label>
                            <input type="password" class="form-control" id="nueva-password" name="nueva-password" placeholder="Introduzca su nueva contraseña." required>
                        </div>
                        <div class="form-group">
                            <label for="password-actual">Repetir nueva contraseña</label>
                            <input type="password" class="form-control" id="nueva-password2" name="nueva-password2" placeholder="Repita su nueva contraseña." required>
                        </div>
                        <div class="custom-control custom-checkbox mt-2">
                            <input type="checkbox" class="custom-control-input" id="mostrarContrasenya">
                            <label class="custom-control-label" for="mostrarContrasenya">Mostrar contraseñas</label>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Restablecer contraseña</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="cerrarModalContrasenya()">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

    <input id="subir-foto-perfil" class="invisible" type="file" accept=".jpg, .jpeg, .png">

    <!-- Scripts -->
    <!-- Validación formularios -->
    <script src="js/validaciones/form-validation.js" type="text/javascript"></script>
    <!-- Operaciones perfil -->
    <script src="js/perfil/perfil.js" type="text/javascript"></script>

<?php include('include/partials/main/footer-main.php');?>