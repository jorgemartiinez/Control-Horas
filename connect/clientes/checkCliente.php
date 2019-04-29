<?php

/* EN ESTE FICHERO COMPROBAREMOS QUE EXISTA EL CLIENTE ASOCIADO A ESTA FICHA EN CONCRETO, PARA ELLO RECIBIREMOS LOS IDS DE USUARIOS EN UN ARRAY Y COMPROBAREMOS QUE
EL USUARIO QUE SE INTENTA BUSCAR EXISTA EN ESTE ARRAY */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require ('connect/BD.php');

if(isset($_GET['cliente'])) {
    $id = $mysqli->real_escape_string($_GET['cliente']);
    try {

        //COMPROBAMOS QUE EXISTA LA ID
        $stmt = $mysqli->prepare(
            "SELECT id FROM users WHERE rol = 0"); //NO QUEREMOS AÑADIR PAQUETES NI TRABAJOS A ADMINS, SOLO CLIENTES

        $stmt->execute();

        $result = $stmt->get_result();

        while ($registro = $result->fetch_assoc()) {
            $idsUsuariosExistentes[] = $registro['id'];
        }

        $stmt->close();

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

?>