<?php

/* DESDE AQUÍ PODREMOS ACTUALIZAR LA CONTRASEÑA DE UN USUARIO DESDE SU PERFIL,
VALIDAMOS LOS DATOS, LOS ENCRIPTAMOS Y REALIZAMOS EL UPDATE */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../../utils/myHelpers.php');

require('../BD.php');
session_start();

if(isset($_POST['password-actual']) && password_verify($_POST['password-actual'], $_SESSION['usuario']['password'])){
    if (isset($_POST['nueva-password']) && isset($_POST['nueva-password2'])
        && $_POST['nueva-password'] == $_POST['nueva-password2']) {

        if(strlen($_POST['nueva-password']) >= 6 && preg_match('/[A-Z]/', $_POST['nueva-password'])
            && preg_match('/[A-Z]/', $_POST['nueva-password'])
            && preg_match('/[0-9]/', $_POST['nueva-password'])) { //pattern para validar que las contraseñas tengan un mínimo de 6 carácteres con mayus, min y algún num
            if(!password_verify($_POST['nueva-password'], $_SESSION['usuario']['password'])){

                $password = $mysqli->real_escape_string($_POST['nueva-password']);

                session_start();
                $id = $_SESSION['usuario']['id']; //se guarda en sesión

                $encriptada = password_hash($password, PASSWORD_BCRYPT, $options); //una vez validada, encriptamos la contraseña

                //DESACTIVAMOS EL AUTO COMMIT PARA PERMITIR TRANSACCIONES
                mysqli_autocommit($mysqli, FALSE);
                $query_success = TRUE;

                /* PROCEDEMOS A LA OPERACIÓN PARA ACTUALIZAR LA CONTRASEÑA */
                $stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE id = ?");

                $stmt->bind_param('si', $encriptada, $id);

                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = FALSE;
                }

                $stmt->close();

                if ($query_success) {
                    echo "OK";
                    mysqli_commit($mysqli);
                } else {
                    echo 'Error';
                    mysqli_rollback($mysqli);
                }
            } else {
                echo "nueva_igual";
            }
        } else {
            echo "error_pass";
        }
    }else {
        echo "no_coinciden";
    }
}else {
    echo "actual_error";
}
