<?php

/* FICHERO PARA ELIMINAR TRABAJO A PARTIR DE SU ID */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require('../BD.php');

if($_POST['trabajo']) {

    $trabajo= $mysqli->real_escape_string($_POST['trabajo']);

    try {

        $stmt = $mysqli->prepare("DELETE FROM items WHERE id = ?");

        $stmt->bind_param('i', $trabajo);

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