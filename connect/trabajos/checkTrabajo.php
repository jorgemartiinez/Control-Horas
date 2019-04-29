<?php

/* A LA HORA DE EDITAR UN TRABAJO NO QUEREMOS QUE SE EDITE LA URL PARA INTENTAR EDITAR UN TRABAJO QUE NO TIENE UN CLIENTE Y VICEVERSA */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require ('connect/BD.php');

if(isset($_GET['trabajo'], $_GET['cliente'])) {
    $idTrabajo = $mysqli->real_escape_string($_GET['trabajo']);
    $idCliente =  $mysqli->real_escape_string($_GET['cliente']);
    try {
        /* Devolverá mayor a 0 si el trabajo con esa id pertenece al cliente la id recibida */
        $stmt = $mysqli->prepare(
            "SELECT count(id) as countTrabajoCliente FROM items WHERE id = ? AND id_client = ? AND data_final = 0 AND caducada = 0 ");

        $stmt->bind_param('ii', $idTrabajo, $idCliente);

        $stmt->execute();

        $result = $stmt->get_result();

        while ($registro = $result->fetch_assoc()) {
            $existeTrabajoYCliente = $registro;
        }

        $stmt->close();

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

?>