<?php

/* DESDE ESTE FICHERO SE CADUCAN LAS HORAS DEL USUARIO, PARA ELLO SE CREA UN TRABAJO CON SU SALDO ACTUAL */
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require('../BD.php');

if(isset($_POST['titulo'], $_POST['horas'], $_POST['descripcion'],
    $_POST['cliente'] )) {

    $horas = $mysqli->real_escape_string($_POST['horas']);

    if($horas > 0) { //las horas son mayores a 0

        //guardamos los datos
        $titulo = $mysqli->real_escape_string($_POST['titulo']);
        $descripcion = $mysqli->real_escape_string($_POST['descripcion']);
        $cliente = $mysqli->real_escape_string($_POST['cliente']);
        $fecha_inicio = date('Y-m-d H:i:s');
        $caducada = 1;

        /* REALIZAMOS LA OPERACIÓN PARA INSERTAR EN LA TABLA ITEMS UN TRABAJO CON LAS HORAS CORRESPONDIENTES A SU SALDO ACTUAL, DE FORMA QUE QUEDARÁ A 0,
        ESTE TRABAJO SOLO SERÁ VISIBLE PARA EL ADMINISTRADOR Y PODRÁ BORRARLO O EDITARLO EN CUALQUIER MOMENTO */

        $stmt = $mysqli->prepare("INSERT INTO items(titulo, descripcio, id_client, data_inici, hores, data_final, caducada) VALUES(?, ?, ?, ? , ?, ? , ?)");

        $stmt->bind_param('ssisdsi', $titulo, $descripcion, $cliente, $fecha_inicio, $horas, $fecha_inicio, $caducada);

        if ($stmt->execute()) {
            echo "OK";

        } else {
            echo "error";
        };

        $stmt->close();
    }else{
        echo "error_saldo";
    }

}
?>