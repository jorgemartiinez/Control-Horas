<!-- Footer Start -->
<footer class="footer mt-2">
    <div class="container-fluid">
        <div class="row"> <br/>
            <div class="col-md-10 text-md-left text-center">
                <div class="row">
                    <div class="col-md-6">
                        <address> <?= $_SESSION['config']['footer-direccion'] ?></address>
                    </div>
                    <div class="col-md-4">
                        <?= $_SESSION['config']['footer-empresa'] ?> &copy;<?= date("Y");?>
                    </div>
                </div>
            </div>
            <div class="col-md-2 text-md-right text-center">
                <a href="mailto:info@pandacreatiu.com" style="color: #98a6ad;"> <?= $_SESSION['config']['footer-email'] ?></a>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->

<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>
<!-- Modal-Effect -->
<script src="assets/libs/custombox/custombox.min.js"></script>
<!-- App js -->
<script src="assets/js/app.min.js"></script>
<!-- Bootstrap Tables js -->
<script src="assets/libs/bootstrap-table/bootstrap-table.min.js"></script>

<!-- Subida imagenes -->
<script src="assets/libs/dropify/dropify.min.js"></script>

<!-- Init js-->
<script src="assets/js/pages/form-fileuploads.init.js"></script>
<!-- FIN SUBIDA -->


<!-- Init js -->
<script src="assets/js/pages/bootstrap-tables.init.js"></script>
<!-- Summernote js -->
<script src="assets/libs/summernote/summernote-bs4.min.js"></script>
<!-- Init js -->
<script src="assets/js/pages/form-summernote.init.js"></script>
<!-- Sweet Alerts js -->
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
<!-- Sweet alert init js-->
<script src="assets/js/pages/sweet-alerts.init.js"></script>
<!-- Notificaciones  -->
<script src="js/notificaciones/alertas.js"></script>

<script type="text/javascript">
    $(function() {
        $('body').css('opacity', 1);
    });
</script>
</body>
</html>
