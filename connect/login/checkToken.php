<?php
/* ESTE FICHERO SERVIRÁ PARA COMPROBAR QUE EL TOKEN RECIBIDO POR LA URL EXISTA, PARA ELLO SE ENVÍA UN ENLACE AL CLIENTE */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require ('connect/BD.php');

$token = $_GET['token'];
$existe = null;

if(isset($_GET['token'])) {

    try {

        /* REALIZAMOS LA OPERACIÓN */
        $stmt = $mysqli->prepare("SELECT * FROM password_reset WHERE token=?");

        $stmt->bind_param('s', $token);

        $stmt->execute();

        $result = $stmt->get_result();

        $count = 0;

        while ($registro = $result->fetch_assoc()) {
            $count++;
            $resultado = $registro;
        }

        //COMPROBAMOS QUE EXISTA LA PETICIÓN ASOCIADA A ESTE TOKEN
        if($count!=0){
            $existe = true;
        }else{
            $existe = false;
        }

        $stmt->close();

    } catch (Exception $e) {
        echo $e->getMessage();
    }

}else{
    $existe = false; //no existe el token introducido
}