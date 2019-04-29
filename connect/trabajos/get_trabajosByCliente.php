<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


/* DESDE AQUÍ OBTENEMOS LOS TRABAJOS POR ID DE CLIENTE */

require ('connect/BD.php');

try {


    $id = $mysqli->real_escape_string($_GET['cliente']);

    /* NOS DEVOLVERÁ LAS TAREAS ORDENADAS POR FECHA INICIO */
    $stmt =$mysqli->prepare("SELECT id, titulo, descripcio, id_client, data_inici, hores, data_final, 
caducada, IF(data_final > 0, true, false) 
AS estado FROM items
WHERE id_client = ? 
ORDER BY data_inici DESC");
    $stmt->bind_param('i', $id);

    $stmt->execute();

    $result = $stmt->get_result();

    while($registro = $result->fetch_assoc() ){

        $dades['id'] = $registro['id'];
        $dades['titulo'] = ($registro['titulo'] != '0' && $registro['titulo'] != '') ? $registro['titulo'] : mb_substr($registro['descripcio'], 0 ,25).'...';
        // si no recibimos título de la tarea, se cogen 25 carácteres de la descripción

        $dades['descripcio'] =  $registro['descripcio'];
        $dades['id_client'] = $registro['id_client'];
        $dades['data_inici'] = $registro['data_inici'];
        $dades['hores'] = getHorasYMinutos($registro['hores']); //formateamos las horas
        $dades['estado'] = $registro['estado'];
        $dades['data_final'] = $registro['data_final'];
        $dades['caducada'] = $registro['caducada'];
        $trabajos[] = $dades;
    }

    $stmt->close();

} catch (Exception $e) {
    echo $e->getMessage();
}

//recibimos un número y lo convertimos a 00:00h
function getHorasYMinutos($time){

    $minutos = $time*60;

    $stringTiempo =  sprintf("%0d:%02dh",   floor($minutos/60), $minutos%60);

    return $stringTiempo;
}


