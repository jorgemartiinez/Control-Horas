<!-- end page -->
<?php if(isset($_SESSION['config'])&&$_SESSION['config']!=null){ ?>
<footer style="font-size: 12px; " class="footer footer-alt">
    <?= $_SESSION['config']['footer-direccion'] ?><br/>
    <a href="mailto:info@pandacreatiu.com" style="color: #98a6ad;"> <?= $_SESSION['config']['footer-email'] ?> </a>
</footer>
<?php }?>
<!-- Vendor js -->
<script src="assets/js/vendor.min.js"></script>
<!-- App js -->
<script src="assets/js/app.min.js"></script>

<!-- Validación formularios -->
<script src="js/validaciones/form-validation.js" type="text/javascript"></script>

<!-- Sweet Alerts js -->
<script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
<!-- Sweet alert init js-->
<script src="assets/js/pages/sweet-alerts.init.js"></script>

<!-- Sweet alert init js-->
<script src="js/notificaciones/alertas.js"></script>

</body>

</html>
