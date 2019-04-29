<?php

/* AQUÍ OBTENDREMOS LOS PAQUETES PARA UN CLIENTE EN CUESTIÓN */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require ('connect/BD.php');

if($_GET['cliente']) {

    $id = $mysqli->real_escape_string($_GET['cliente']);

    try {
        /* REALIZAMOS LA OPERACIÓN, ORDENANDO POR FECHA DE INICIO */
        $stmt = $mysqli->prepare("SELECT * FROM horas WHERE id_client = ? ORDER BY data_inici DESC");

        $stmt->bind_param('i', $id);

        $stmt->execute();

        $result = $stmt->get_result();

        while ($registro = $result->fetch_assoc()) {
            $paquetes[] = $registro;
        }

        $stmt->close();
    } catch (Exception $e) {
        echo $e->getMessage();
    }

}