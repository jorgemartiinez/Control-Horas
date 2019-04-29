<?php

/* DESDE ESTE FICHERO ENVIAREMOS EL CORREO NECESARIO
PARA REINICIAR LA CONTRASEÑA DEL USUARIO,
PARA ELLO LE ENVIAREMOS UN CORREO CON UN TOKEN */


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

const MAX_PETICIONES = 2;

if(isset($_POST['email'])) {

    require('../BD.php');

    require('../../utils/myHelpers.php');

    $email = $mysqli->real_escape_string($_POST['email']);


    try {
        /* VAMOS A COMPROBAR QUE EL USUARIO EXISTA */
        $stmt = $mysqli->prepare("SELECT * FROM users WHERE email=?");

        $stmt->bind_param('s', $email);

        $stmt->execute();

        $result = $stmt->get_result();

        $count = 0;

        while ($registro = $result->fetch_assoc()) {
            $count++;
            $cliente = $registro;

        }

        $stmt->close();

    } catch (Exception $e) {
        echo $e->getMessage();
    }

    if ($count != 0) { //SI EXISTE, PROCEDEMOS A REALIZAR LA PETICIÓN

        if (peticionMenorADos($mysqli, $cliente['id'])) { //COMPROBAMOS QUE EL USUARIO NO HAYA REALIZADO YA ALMENOS 2 PETICIONS


            $token = md5(rand(999, 99999)); //GENERAMOS UN TOKEN ALEATORIO Y LO ENCRIPTAMOS

            $hoy = date('Y-m-d H:i:s');

            $expira = date('Y-m-d H:i:s', strtotime($hoy . ' + 1 day')); //EL TOKEN EXPIRARÁ EN UN DÍA EMPEZANDO POR ESTE MOMENTO

            $id_client = $cliente['id'];

            //DESACTIVAMOS EL AUTO COMMIT PARA PERMITIR TRANSACCIONES
            mysqli_autocommit($mysqli, FALSE);
            $query_success = TRUE;

            /* INSERTAMOS PETICIÓN CAMBIO CONTRASEÑA EN PASSWORD_RESET */

            $stmt = $mysqli->prepare("INSERT INTO password_reset(id_client, token, expira) VALUES(?, ?, ?)");

            $stmt->bind_param('iss', $id_client, $token, $expira);


            if (!mysqli_stmt_execute($stmt)) {
                $query_success = FALSE;
            }

            $stmt->close();


            if ($query_success) { //TODO OK, ENVIAMOS CORREO
                echo "OK";
                mysqli_commit($mysqli);

                require_once("../../utils/enviarCorreo.php");

                /* ENVIAMOS EL CORREO CON EL TOKEN */

                $emailCliente = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
                try {
                    enviarCorreoToken('Cambio de contraseña',
                        $emailCliente, $cliente['nom'], 'peticion_password', $token);

                } catch (phpmailerException $e) {
                    echo $e->errorMessage();
                } catch (Exception $e) {
                    echo $e->getMessage();
                }

            } else { //HA FALLADO LA OPERACIÓN, HACEMOS ROLLBACk
                echo 'Error';
                mysqli_rollback($mysqli);
            }
        } else {
            echo "max_peticiones";

        }

    } else {
        echo "no_existe";

    }
}


//FUNCIÓN PARA COMPROBAR QUE EL USUARIO NO HAYA PEDIDO YA ALMENOS DOS PETICIONES

function peticionMenorADos($mysqli, $idCliente){

    $stmt = $mysqli->prepare("SELECT count(id) as numResultados FROM password_reset WHERE id_client = ? AND expira > NOW()");

    $stmt->bind_param('i', $idCliente);

    $stmt->execute();

    $result = $stmt->get_result();

    while($registro = $result->fetch_assoc() ){
        $numPasswordResets = $registro;
    }

    $stmt->close();

    if($numPasswordResets['numResultados'] < MAX_PETICIONES){ //si el usuario ha pedido un cambio de contraseña menos de 2 veces
        return true;
    }else{
        return false;
    }
}

