<?php

/* DESDE AQUÍ CREAMOS LAS TABLAS NECESARIAS PARA LA EJECUCIÓN DEL PANEL */

if($_POST) {

    require ('../../utils/myHelpers.php');
    require ('../BD.php');

    /* CREAMOS BD */
    $commands = file_get_contents('../ficheros_sql/controlhores.sql');

    if ($mysqli->multi_query($commands) === TRUE) { //con multiquery realizamso las operaciones del control de horas
        echo "OK";
    } else {
        echo "Error";
    }
}