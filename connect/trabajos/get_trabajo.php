<?php
/* FICHERO PARA OBTENER UN TRABAJO A PARTIR DE SU ID */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if(file_exists('connect/BD.php')) {
    require('connect/BD.php');
    require ('utils/myHelpers.php');
}else{
    require('../BD.php');
    require('../../utils/myHelpers.php');
}



if(isset($_GET['trabajo'])) {
    $id = $mysqli->real_escape_string($_GET['trabajo']);

    try {

        /* PETICIÓN TRABAJO EN BASE A ID */

        $stmt = $mysqli->prepare(
            "SELECT * FROM items 
                WHERE id=?");

        $stmt->bind_param('i', $id);

        $stmt->execute();

        $result = $stmt->get_result();

        while ($registro = $result->fetch_assoc()) {
            $trabajo = $registro;
        }


        //formateamos las horas recibidas de la base de datos
        $trabajoHoras = $trabajo['hores'];

        $horas = (int) $trabajoHoras;

        $minutos = formatMinutosAHTML($trabajoHoras);


        if(isset($_GET['show'])) {
            if ($_GET['show'] == true) {
                echo json_encode($trabajo);
            }
        }

        $stmt->close();

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
