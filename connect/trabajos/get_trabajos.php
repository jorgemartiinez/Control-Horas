<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require ('connect/BD.php');
try {


    $id = $mysqli->real_escape_string($_GET['cliente']);

    $stmt =$mysqli->prepare("SELECT id, titulo, descripcio, id_client, data_inici, hores, data_final, 
caducada, IF(data_final > 0, true, false) 
AS estado FROM items
WHERE id_client = ?
ORDER BY caducada ASC, data_final DESC");
    $stmt->bind_param('i', $id);

    $stmt->execute();

    $result = $stmt->get_result();

    while($registro = $result->fetch_assoc() ){

        $dades['id'] = $registro['id'];
        $dades['titulo'] = ($registro['titulo'] != '0') ? $registro['titulo'] : mb_substr($registro['descripcio'], 0 ,25).'...';
        $dades['descripcio'] =  $registro['descripcio'];
        $dades['id_client'] = $registro['id_client'];
        $dades['data_inici'] = $registro['data_inici'];

        $dades['hores'] = getHorasYMinutos($registro['hores']);
        $dades['estado'] = $registro['estado'];
        $dades['data_final'] = $registro['data_final'];
        $dades['caducada'] = $registro['caducada'];
        $trabajos[] = $dades;
    }

    $stmt->close();

} catch (Exception $e) {
    echo $e->getMessage();
}

function getHorasYMinutos($time){

    $minutos = $time*60;

    $stringTiempo =  sprintf("%0d:%02dh",   floor($minutos/60), $minutos%60);

    return $stringTiempo;
}


