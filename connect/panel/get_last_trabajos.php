<?php
/* FICHERO PARA OBTENER LOS ÚLTIMOS TRABAJOS AÑADIDOS, SE MOSTRARÁN EN LA PARTE DEL PANEL DE ADMIN */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require ('connect/BD.php');

try {

    /* REALIZAMOS LA OPERACIÓN, LIMITADONO y ORDENANDO POR FECHA, LAS TAREAS QUE SERVIRÁN PARA CADUCAR LAS HORAS NO LAS MOSTRAREMOS AQUÍ */
    $stmt =$mysqli->prepare("SELECT items.descripcio, items.hores, IF(data_final > 0, true, false) 
AS estado, items.data_inici, items.caducada, users.id AS usuario, users.nom, imagenes.perfil 
FROM items 
LEFT JOIN users ON items.id_client = users.id
LEFT JOIN imagenes ON users.id = imagenes.id_client

 WHERE items.caducada = 0 ORDER BY items.data_inici DESC LIMIT 5");

    $stmt->execute();

    $result = $stmt->get_result();

    while($registro = $result->fetch_assoc() ){
        $trabajos[] = $registro;
    }

    $stmt->close();

} catch (Exception $e) {
    echo $e->getMessage();
}




