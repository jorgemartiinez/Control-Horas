<?php

/* DESDE AQUÍ SIMPLEMENTE BORRAREMOS UN USUARIO Y SU FOTO DE PERFIL EN BASE A SU ID */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require ('../BD.php');
require('../config.php');


if($_POST['id']) {
    $url_schema = parse_url($GLOBALS['config']['rutaAbsoluta']);
    $target_dir = $_SERVER["DOCUMENT_ROOT"].$url_schema['path'].'uploads/perfil/';
    $id= $mysqli->real_escape_string($_POST['id']);

    try {

//DESACTIVAMOS EL AUTO COMMIT PARA PERMITIR TRANSACCIONES
        mysqli_autocommit($mysqli, FALSE);
        $query_success = TRUE;

        /* BUSCAMOS LA FOTO DE PERFIL DEL CLIENTE QUE VAMOS A BORRAR */
        $stmt = $mysqli->prepare("SELECT perfil FROM imagenes WHERE id_client = ?");

        $stmt->bind_param('i', $id);

        if (!mysqli_stmt_execute($stmt)) {
            $query_success = FALSE;
        }else{ //si la operación sale correctamente, almacenamos el nombre del archivo
            $result = $stmt->get_result();
            while ($registro = $result->fetch_assoc()) {
                $imagenPerfilABorrar = $registro;
            }
        }

        $stmt->close();

        /* BORRAMOS POR ID */
        $stmt = $mysqli->prepare("DELETE FROM users WHERE id = ?");

        $stmt->bind_param('i', $id);

        if (!mysqli_stmt_execute($stmt)) {
            $query_success = FALSE;
        }

        $stmt->close();

        if ($query_success) { //TODO OK, COMMIT Y BORRAMOS FOTO
            echo 'OK';
            mysqli_commit($mysqli);
            if($imagenPerfilABorrar['perfil']!='user-default.png') {
                unlink($target_dir . $imagenPerfilABorrar['perfil']); //se borra la anterior
            }
        } else {
            echo 'Error';
            mysqli_rollback($mysqli);
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}