<?php

/* ARCHIVO QUE SERVIRÁ PARA DESINSTALAR EL PANEL Y VOLVER AL APARTADO DE INSTALACIÓN INICIAL */


/* BORRARÁ LA BASE DE DATOS Y LAS IMÁGENES */

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    require '../BD.php';

    $mysqli->query('SET foreign_key_checks = 0');
    if ($result = $mysqli->query("SHOW TABLES")) {
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $mysqli->query('DROP TABLE IF EXISTS ' . $row[0]);
        }
    }

    $mysqli->query('SET foreign_key_checks = 1');
    $mysqli->close();

    unlink('../BD.php');
    unlink('../config.php');


    /* BORRAR TODOS A EXCEPCIÓN DE LOS QUE ESTÉN EN EL ARRAY LEAVE FILES */
    $dir = '../../uploads/perfil';
    $leave_files = array('user-default.png');

    foreach (glob("$dir/*") as $file) {
        if (!in_array(basename($file), $leave_files))
            unlink($file);
    }

    $dir = '../../uploads/logo';

    foreach (glob("$dir/*") as $file) {
        unlink($file);
    }

    echo "OK";
}