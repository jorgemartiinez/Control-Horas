<?php

/* DESDE AQUÍ SE CAMBIARÁ EL ESTADO DEL CLIENTE, SI SE QUEDA A 0 NO PODRÁ INICIAR SESIÓN EN EL SITIO */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require ('../BD.php');


if(isset($_POST['id'], $_POST['estado'])) {
    $id= $mysqli->real_escape_string($_POST['id']);
    $estado = (int) $mysqli->real_escape_string($_POST['estado']);
    try {

        /* ACTUALIZAMOS ESTADO CLIENTE */
        $stmt = $mysqli->prepare("UPDATE users SET estado = ? WHERE id = ?");

        $stmt->bind_param('ii', $estado, $id);

        if ($stmt->execute()) {
            echo "OK";
        } else {
            echo "Error";
        };

        $stmt->close();

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
