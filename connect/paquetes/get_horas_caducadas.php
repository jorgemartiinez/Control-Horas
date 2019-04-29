<?php

/* QUEREMOS MARCAR EN EL SUBMENÚ DE CLIENTES CUÁLES NO TIENEN SALDO O LES HA CADUCADO, POR LO QUE DESDE ESTE FICHERO OBTENDREMOS
LOS ID DE ESTOS USUARIOS Y LOS GUARDAREMOS EN UN ARRAY PARA PODER REALIZAR ESTA OPERACIÓN */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require ('connect/BD.php');

try {

    /* BUSCAMOS LAS IDS DE LOS CLIENTES QUE TIENEN HORAS CADUCADAS */
    $stmt =$mysqli->prepare("SELECT id_client FROM horas WHERE data_final > NOW() GROUP BY id_client");

    $stmt->execute();

    $result = $stmt->get_result();

    while($registro = $result->fetch_assoc() ){
        $horasCaducadas[] = $registro['id_client'];
    }

    $stmt->close();
} catch (Exception $e) {
    echo $e->getMessage();
}

