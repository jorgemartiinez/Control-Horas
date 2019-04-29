<?php

/* FICHERO QUE SERVIRÁ PARA AÑADIR UN NUEVO CLIENTE Y ENVIARLE UN CORREO ELECTRÓNICO CON USUARIO Y CONTRASEÑA */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require ('../BD.php');
require ('../../utils/myHelpers.php');


if(isset($_POST['email'], $_POST['nombre'], $_POST['rol'])) {
    $email = $mysqli->real_escape_string($_POST['email']);

    if (noExiste($mysqli, $email)) { //COMPROBAMOS QUE EL USUARIO NO EXISTA EN LA BASE DE DATOS

        $nombre = $mysqli->real_escape_string($_POST['nombre']);
        $rol = $mysqli->real_escape_string($_POST['rol']);
        $password =generarContrasenya(); //GENERAMOS UNA CONTRASEÑA ALEATORIA
        $encriptada = password_hash($password, PASSWORD_DEFAULT, $options); //LA ENCRIPTAMOS
        $fecha_alta = date('Y-m-d H:i:s');


        //DESACTIVAMOS EL AUTO COMMIT PARA PERMITIR TRANSACCIONES
        mysqli_autocommit($mysqli, FALSE);
        $query_success = TRUE;

        /* INSERTAMOS EN USUARIOS */

        $stmt = $mysqli->prepare("INSERT INTO users(nom, rol, email, data_alta, password) VALUES(?, ?, ?, ? , ?)");

        $stmt->bind_param('sisss', $nombre, $rol, $email, $fecha_alta, $encriptada);

        if (!mysqli_stmt_execute($stmt)) {
            $query_success = FALSE;
        }
        $id_cliente = $stmt->insert_id;

        $stmt->close();


        /* INSERTAMOS EN CLIENTES */

        $stmt = $mysqli->prepare("INSERT INTO imagenes (id_client) VALUES(?)");

        $stmt->bind_param('i', $id_cliente);
        if (!mysqli_stmt_execute($stmt)) {
            $query_success = FALSE;
        }

        $stmt->close();


        /* COMPROBAMOS QUE LA TRANSACCIÓN HA SIDO REALIZADA CORRECTAMENTE, PARA HACER COMMIT O ROLLBACK */

        if ($query_success) {
            require_once("../../utils/enviarCorreo.php");
            echo 'OK';

            mysqli_commit($mysqli);

            /* LA OPERACIÓN HA SALIDO CORRECTAMENTE, POR LO QUE ENVIAMOS EL EMAIL */
            try {

                enviarCorreoAltaCliente('Alta usuario Panda Creatiu',
                    $email, $nombre, 'nuevo_cliente', $password);
            } catch (phpmailerException $e) {
                echo $e->errorMessage();
            } catch (Exception $e) {
                echo $e->getMessage();
            }

        } else {
            echo 'Error';
            mysqli_rollback($mysqli);
        }

    }else{
        echo "ya_existe";
    }
}



?>