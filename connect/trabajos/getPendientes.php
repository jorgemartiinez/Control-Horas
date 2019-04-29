<?php

/* NOS DEVOLVERÁ EL NÚMERO DE TAREAS PENDIENTES */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require ('connect/BD.php');

try {

    //Nos devolverá el número de areas pendientes de cada cliente */
    $stmt =$mysqli->prepare("SELECT COUNT(items.id) AS pendientes, items.id_client AS cliente, users.nom, imagenes.perfil FROM items INNER JOIN users ON items.id_client = users.id INNER JOIN imagenes ON users.id = imagenes.id_client WHERE items.data_final <= 0 GROUP BY items.id_client");

    $stmt->execute();

    $result = $stmt->get_result();
    $numPendientes = mysqli_num_rows($result);

    while($registro = $result->fetch_assoc() ){
        $pendientes[] = $registro;
    }

    $stmt->close();


} catch (Exception $e) {
    echo $e->getMessage();
}




