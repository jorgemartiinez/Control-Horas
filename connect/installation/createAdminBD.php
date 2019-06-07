<?php

/* DESDE AQUÍ CREAMOS EL USUARIO ADMINISTRADOR PARA ENTRAR POR PRIMERA VEZ AL PANEL DESPUÉS DE LA INSTALACIÓN */
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

if(isset($_POST['nombre'],$_POST['pass1'],$_POST['pass2'])) {

    require ('../BD.php');
    require ('../../utils/myHelpers.php');

    $nombre = $mysqli->real_escape_string($_POST['nombre']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $pass1 = $mysqli->real_escape_string($_POST['pass1']);
    $pass2 = $mysqli->real_escape_string($_POST['pass2']);
    $rol = 1;
    $fecha_alta = date('Y-m-d H:i:s');
    $encriptada = password_hash($pass1, PASSWORD_DEFAULT, $options); //LA ENCRIPTAMOS

    mysqli_autocommit($mysqli, FALSE);
    $query_success = TRUE;

    /* INSERTAMOS USUARIO */
    $stmt = $mysqli->prepare("INSERT INTO users(nom, rol, email, data_alta, password) VALUES(?, ?, ?, ?, ?)");

    $stmt->bind_param('sisss', $nombre, $rol, $email, $fecha_alta, $encriptada);

    if (!mysqli_stmt_execute($stmt)) {
        $query_success = FALSE;
    }
    $id_cliente = $stmt->insert_id;

    $stmt->close();

    /* IMAGEN POR DEFECTO */
    $stmt = $mysqli->prepare("INSERT INTO imagenes (id_client) VALUES(?)");

    $stmt->bind_param('i', $id_cliente);
    if (!mysqli_stmt_execute($stmt)) {
        $query_success = FALSE;
    }

    $stmt->close();

    if ($query_success) {
        mysqli_commit($mysqli);
        require_once("../../utils/enviarCorreo.php");
        echo 'OK';

        mysqli_commit($mysqli);

        /* LA OPERACIÓN HA SALIDO CORRECTAMENTE, POR LO QUE ENVIAMOS EL EMAIL */
        try {

            enviarCorreoAltaCliente('Alta usuario Panda Creatiu',
                $email, $nombre, 'nuevo_cliente', $pass1);


            session_start();
            session_destroy(); //finalizamos la variable sesión que servía para controlar el orden de instalación

        } catch (phpmailerException $e) {
            echo $e->errorMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    } else {
        echo 'Error';
        mysqli_rollback($mysqli);
    }
}