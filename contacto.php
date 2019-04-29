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
                <div class="container-fluid ">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="panel">Panel</a></li>
                                        <li class="breadcrumb-item active">Contacto</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2 mb-2 card-box">
                        <div class="col-12 text-center">
                            <h1>Contacto</h1>
                            <span>No dude en contactarnos si tiene cualquier problema. Intentaremos responderle con la mayor brevedad posible.</span>
                        </div>
                    </div>

                    <div class="row card-box">
                        <div class="col-md-6 col-12 ">
                            <form id="form-contacto">
                                <div class="form-group">
                                    <label for="titulo">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" placeholder="Introduzca su nombre." maxlength="60" onkeyup="comprobarCampo(this)" required>
                                </div>

                                <div class="form-group">
                                    <label for="horas">Email</label>
                                    <input type="email" class="form-control" id="email"  placeholder="Introduzca su correo electrónico." onkeyup="comprobarCampo(this)" required>
                                </div>

                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" type="text" id="descripcion" minlength="10" maxlength="100" onkeyup="comprobarCampo(this)" placeholder="Descripción de su problema..." required></textarea>
                                    <small id="descripcionHelp" class="form-text text-muted">Descríbanos su problema. Mínimo de 10 carácteres.</small>
                                </div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light" id="enviarContacto">Enviar</button>
                            </form>
                        </div>

                        <div class="col-md-6 col-12 mt-3">

                            <ul class="list-group">
                                <li class="list-group-item bg-dark text-white" >Información contacto</li>
                                <li class="list-group-item"><em class="fas fa-home"></em> Carrer Santa Llucia, 3A, 03801 Alcoi, Alacant</li>
                                <li class="list-group-item"><em class="fas fa-envelope"></em> info@pandacreatiu.com</li>
                                <li class="list-group-item"><em class="fas fa-phone"></em> 865 71 34 90</li>
                            </ul>
                        </div>
                    </div>
                    <!-- end row-->
                </div>
            </div>
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


<!-- Validación formularios -->
<script src="js/validaciones/form-validation.js" type="text/javascript"></script>

<!-- Validar y enviar correo contacto -->
<script src="js/contacto/contacto.js" type="text/javascript"></script>

<?php include('include/partials/main/footer-main.php');?>