<?php

/* ARCHIVO QUE SE ENCARGARÁ DE VOLVER AL ESTADO INICIAL DEL PANEL, NO SE BORRARÁN LOS ARCHIVOS DE CONFIGURACIÓN Y
SE RESTABLECERÁ LA BASE DE DATOS BORRANDO SOLO LOS USUARIOS QUE TENGAN EL ROL DE CLIENTE, BORRANDO LAS IMAGENES DE CADA UNO DE ELLOS */


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    require '../BD.php';

    mysqli_autocommit($mysqli, FALSE);
    $query_success = TRUE;

    /* OPERACIONES REINICIAR BD */

    $stmt = $mysqli->prepare("DELETE FROM users WHERE rol = 0");

    if (!mysqli_stmt_execute($stmt)) {
        $query_success = FALSE;
    }

    $stmt->close();

    $stmt = $mysqli->prepare("TRUNCATE TABLE password_reset");

    if (!mysqli_stmt_execute($stmt)) {
        $query_success = FALSE;
    }

    $stmt->close();

    $stmt = $mysqli->prepare("TRUNCATE TABLE config");

    if (!mysqli_stmt_execute($stmt)) {
        $query_success = FALSE;
    }

    $stmt->close();


    $stmt = $mysqli->prepare("INSERT INTO config (clave, valor) VALUES
('logo', ''), ('footer-direccion', ''), ('footer-empresa', ''), ('footer-email', '')");

    if (!mysqli_stmt_execute($stmt)) {
        $query_success = FALSE;
    }

    $stmt->close();


    if ($query_success) {
        echo "OK";
        mysqli_commit($mysqli);

        /* SI TODO A IDO OK, LIMPIAMOS LAS IMAGENES */

        $stmt =$mysqli->prepare("SELECT * FROM imagenes");

        $stmt->execute();

        $result = $stmt->get_result();

        while($registro = $result->fetch_assoc() ){
            $imagenes[] = $registro;
        }

        $stmt->close();


        /* BORRAR TODOS A EXCEPCIÓN DE LOS QUE ESTÉN EN EL ARRAY LEAVE FILES, EN ESTE CASO LAS IMÁGENES QUE NO ESTÉN EN LA TABLE IMAGENES,
        SIGNIFICARÁ QUE NO PERTENECEN A NINGÚN USUARIO */

        $leave_files = array();
        $leave_files[] = 'user-default.png';

        foreach ($imagenes as $imagen){
            if($imagen['perfil'] != 'user-default.png') {
                $leave_files[] = $imagen['perfil'];
            }
        }


        $dir = '../../uploads/perfil';

        foreach (glob("$dir/*") as $file) {
            if (!in_array(basename($file), $leave_files))
                unlink($file);
        }


        $dir = '../../uploads/logo';

        foreach (glob("$dir/*") as $file) {
            unlink($file);
        }

    } else {
        echo 'Error';
        mysqli_rollback($mysqli);
    }

}