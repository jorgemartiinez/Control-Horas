<?php

/* EN EL PANEL DE ADMINISTRADOR MOSTRAREMOS VARIAS ESTADÍSTICAS CÓMO NUMERO DE TRABAJOS AÑADIDOS, CLIENTES, ETC.

LOS DATOS LOS OBTENDREMOS DESDE AQUÍ */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require ('connect/BD.php');

try {


    /* REALIZAMOS LA OPERACIÓN */
    $stmt =$mysqli->prepare("SELECT COUNT(id) AS numClientes, (SELECT COUNT(id) FROM users WHERE rol = 1) AS numAdmins, (SELECT COUNT(id) FROM horas ) AS numPaquetes,  (SELECT COUNT(id) FROM items) AS numTrabajos FROM users WHERE rol = 0");

    $stmt->execute();

    $result = $stmt->get_result();

    while($registro = $result->fetch_assoc() ){
        $stats = $registro;
    }

    $stmt->close();


    //se inicializan las variables para mostrarlas a 0 si no se recibe nada
    $numClientes = 0;
    $numAdmins = 0;
    $numTrabajos = 0;
    $numPaquetes = 0;


    if(isset($stats) && $stats!=null){
        $numClientes = $stats['numClientes'];
        $numAdmins = $stats['numAdmins'];
        $numTrabajos = $stats['numTrabajos'];
        $numPaquetes = $stats['numPaquetes'];
    }



} catch (Exception $e) {
    echo $e->getMessage();
}




