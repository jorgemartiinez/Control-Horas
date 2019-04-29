<?php
/* OBTENEMOS TODOS LOS PAQUETES, ORDENADOS POR FECHA DE INICIO, OBTENIENDO ADEMÁS EL NOMBRE DEL USUARIO AL QUE PERTENECE CON LEFT JOIN*/
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require ('connect/BD.php');


try {

    /* CON ESTA CONSULTA OBTENDREMOS EL NOMBRE DEL CLIENTE Y SUS HORAS */
    $stmt = $mysqli->prepare("SELECT users.nom, horas.id, horas.id_client as cliente,horas.horas, horas.data_inici, horas.data_final, imagenes.perfil 
FROM horas 
LEFT JOIN users 
ON horas.id_client = users.id
LEFT JOIN imagenes 
ON users.id = imagenes.id_client
ORDER BY horas.data_inici DESC
");

    $stmt->execute();

    $result = $stmt->get_result();

    while ($registro = $result->fetch_assoc()) {
        $paquetes[] = $registro;
    }

    $stmt->close();

} catch (Exception $e) {
    echo $e->getMessage();
}
