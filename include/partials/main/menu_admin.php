<?php

//obtenemos los usuarios
require('connect/clientes/get_usuarios.php');

//ids de usuarios con horas caducadas
require('connect/paquetes/get_horas_caducadas.php');

?>
    <li>
        <a href="gestion-paquetes">
            <i class="fe-box"></i>
            <span> Packs Horas</span></a>
    </li>

<?php if(strpos($_SERVER['REQUEST_URI'],'usuario')!== false){?>
    <li class="active" style="cursor: pointer">
    <a class="active">
<?php }else{?>
    <li style="cursor: pointer">
    <a>
<?php }?>
    <i class="fe-database"></i>
    <span> Gestión Clientes </span>
    <span class="menu-arrow"></span>
    </a>
    <ul class="nav-second-level" aria-expanded="false">
        <li <?php if(isset($_GET['rol'])&&strpos($_SERVER['REQUEST_URI'],'usuario') !== false
            && $_GET['rol']==1){?> class="active" <?php } ?>>
            <a href="usuarios?rol=1">Administradores</a>
        </li>
        <li <?php if(isset($_GET['rol'])&&strpos($_SERVER['REQUEST_URI'],'usuario') !== false
            && $_GET['rol']==0){?> class="active" <?php } ?>>
            <a href="usuarios?rol=0">Clientes</a>
        </li>
    </ul>
    </li>

<?php

if(isset($resultados) && count($resultados)){
    foreach($resultados as $cliente ){ //COMPROBAREMOS QUE ESTÉ ABIERTA LA PÁGINA EN CUESTIÓN PARA AÑADIR LA CLASE ACTIVA

        if($cliente['rol'] == 0){?>
            <?php if(isset($_GET['cliente'])&& $_GET['cliente']==$cliente['id']){?>
                <li class="active" style="cursor:pointer">
                <a class="active" >
            <?php }else{ ?>
                <li style="cursor:pointer">
                <a style="cursor:pointer">
            <?php } ?>
            <i class='fe-user'></i>
            <span > <?php echo $cliente['nom']; if(!in_array($cliente['id'], $horasCaducadas)){ ?> <i class="fe-clock text-danger"></i><?php }?></span>
            <span class='menu-arrow'></span>
            </a>
            <ul class='nav-second-level' aria-expanded='false'>
                <li <?php if(isset($_GET['cliente'])&&strpos($_SERVER['REQUEST_URI'],'ficha') !== false
                    && $_GET['cliente']==$cliente['id']){?> class="active" <?php } ?>>
                    <a href='ficha?cliente=<?= $cliente['id']?>'>Ver Ficha</a>
                </li>
                <li <?php if(isset($_GET['cliente'])&&strpos($_SERVER['REQUEST_URI'],'trabajos') !== false
                    && $_GET['cliente']==$cliente['id']){?> class="active" <?php } ?>>
                    <a href='trabajos?cliente=<?= $cliente['id']?>'>Trabajos</a>
                </li>
                <li <?php if(isset($_GET['cliente'])&&strpos($_SERVER['REQUEST_URI'],'paquetes') !== false
                    && $_GET['cliente']==$cliente['id']){?> class="active" <?php } ?>>
                    <a href='paquetes?cliente=<?= $cliente['id']?>'>Packs Horas</a>
                </li>
            </ul>
            </li>
        <?php }}}?>