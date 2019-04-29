<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
    <div class="slimscroll-menu">
        <!-- User box -->
        <div class="user-box text-center">
            <img style="border: 1px solid #dddada" src="scripts/TimThumb/mthumb.php?src=<?php echo "uploads/perfil/".$_SESSION['usuario']['perfil']; ?>&w=100&h=100&zc=2&q=95" alt="user-img" class="rounded-circle avatar-md">
            <div class="dropdown">
                <a style="cursor: pointer" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block" data-toggle="dropdown"><?php echo $_SESSION['usuario']['nom'] ?></a>
                <div class="dropdown-menu user-pro-dropdown">
                    <!-- item-->
                    <a href="perfil" class="dropdown-item notify-item">
                        <i class="fe-user mr-1"></i>
                        <span>Mi cuenta</span>
                    </a>
                    <!-- item-->
                    <a href="connect/login/logout.php" class="dropdown-item notify-item">
                        <i class="fe-log-out mr-1"></i>
                        <span>Cerrar sesión</span>
                    </a>
                </div>
            </div>
            <?php if(($_SESSION['usuario']['rol'])==1) echo "<p class='text-muted'>Administrador</p>"; else {echo "<p class='text-muted'>Cliente</p>";} ?>
        </div>
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <ul class="metismenu in" id="side-menu">
                <li class="menu-title">Navegación</li>
                <li>
                    <a href="panel">
                        <i class="fe-airplay"></i>
                        <span> Panel </span>
                    </a>
                </li>
                <?php /*si eres admin o cliente, tendrás un menú u otro*/ if($_SESSION['usuario']['rol']){include ('include/partials/main/menu_admin.php');}else{ include ('include/partials/main/menu_cliente.php');} ?>
            </ul>
        </div>
        <!-- End Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>
<!-- Left Sidebar End -->