<?php

/* DESDE AQUÍ BORRAREMOS LOS PAQUETES */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('../BD.php');

if(isset($_POST['paquete'])) {

    $paquete= $mysqli->real_escape_string($_POST['paquete']);

    try {

        /* RECIBIMOS LA ID DEL PAQUETE Y LO ELIMINAMOS */
        $stmt = $mysqli->prepare("DELETE FROM horas WHERE id = ?");

        $stmt->bind_param('i', $paquete);

        if ($stmt->execute()) {
            echo "OK";
        } else {
            echo "Error";
        };

        $stmt->close();

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}