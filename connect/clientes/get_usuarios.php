<?php
/* OBTENDREMOS TODOS LOS USUARIOS DE LA BASE DE DATOS, HAREMOS UN INNER JOIN CON IMAGENES PARA OBTENER TAMBIÉN SU FOTO DE PERFIL */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require ('connect/BD.php');

try {

    $stmt =$mysqli->prepare("SELECT users.id, users.nom, users.email, users.rol, users.estado, 
users.email, users.data_alta , imagenes.perfil
FROM users
 INNER JOIN imagenes 
 ON users.id = imagenes.id_client
 ");

    $stmt->execute();

    $result = $stmt->get_result();

    while($registro = $result->fetch_assoc() ){
        $resultados[] = $registro;
    }

    $stmt->close();
} catch (Exception $e) {
    echo $e->getMessage();
}

