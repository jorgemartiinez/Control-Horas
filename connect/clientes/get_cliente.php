<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require ('../BD.php');

if(isset($_GET['cliente'])) {
    $id = $_GET['cliente'];
    $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
    try {

        $stmt = $mysqli->prepare(
            "SELECT users.id, users.nom, users.rol, users.estado, users.email, users.data_alta, imagenes.perfil 
                FROM users 
                INNER JOIN imagenes 
                on users.id = imagenes.id_client 
                WHERE users.id=?");

        $stmt->bind_param('i', $id);

        $stmt->execute();

        $result = $stmt->get_result();

        while ($registro = $result->fetch_assoc()) {
            $resultado = $registro;
        }


        if (strpos($url,'paquetes') == false) {
            $respuesta = json_encode($resultado);
            echo $respuesta;
        }

        $stmt->close();

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}