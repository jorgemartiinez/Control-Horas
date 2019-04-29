<?php
/* OBTENEMOS EL PAQUETE EN CUESTIÓN SIN FILTRAR POR CLIENTE */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require('../BD.php');

$id = $_GET['cliente'];


if(isset($_GET['cliente'])) {

    try {

        $stmt = $mysqli->prepare(
            "SELECT *  
                FROM horas
                WHERE id=?");

        $stmt->bind_param('i', $id);

        $stmt->execute();

        $result = $stmt->get_result();

        while ($registro = $result->fetch_assoc()) {
            $paquete = $registro;
        }

        $paqueteJSON = json_encode($paquete);
        echo $paqueteJSON;

        $stmt->close();

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}