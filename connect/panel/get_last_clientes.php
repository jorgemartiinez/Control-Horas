<?php

/* FICHERO PARA OBTENER LOS ÚLTIMOS CLIENTES AÑADIDOS, SE MOSTRARÁN EN LA PARTE DEL PANEL DE ADMIN */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require ('connect/BD.php');


try {

    /* REALIZAMOS LA OPERACIÓN, LIMITADO A 5 y ORDENADO POR FECHA */
    $stmt =$mysqli->prepare("SELECT users.id, users.nom, users.email, users.rol, users.data_alta, imagenes.perfil as perfil FROM users INNER JOIN imagenes ON users.id = imagenes.id_client  
WHERE users.rol = 0  ORDER BY users.data_alta DESC  LIMIT 5");

    $stmt->execute();

    $result = $stmt->get_result();

    while($registro = $result->fetch_assoc() ){
        $ultimosClientes[] = $registro;
    }

    $stmt->close();

} catch (Exception $e) {
    echo $e->getMessage();
}




