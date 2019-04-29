<?php

/* ESTE FICHERO SIRVE PARA REINICIAR LA CONTRASEÑA DEL CLIENTE,
LA CAMBIAREMOS EN BASE A UN TOKEN RECIBIDO POR EMAIL
PARA ASEGURARNOS DE QUE ES EL CLIENTE EL QUE LA CAMBIA */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require ('../../utils/myHelpers.php');

require('../BD.php');

if(isset($_POST['token'])) { //SI NO RECIBIMOS EL TOKEN NO HAREMOS NADA
    if (isset($_POST['pass']) && isset($_POST['pass']) && $_POST['pass'] == $_POST['pass2']) { //SE COMPRUEBA QUE LAS CONTRASEÑAS COINCIDEN
        if (strlen($_POST['pass']) >= 6 && preg_match('/[A-Z]/', $_POST['pass']) && preg_match('/[A-Z]/', $_POST['pass'])
            && preg_match('/[0-9]/', $_POST['pass']) ) { //MEDIANTE UNA EXPRESIÓN REGULAR COMPROBAMOS QUE LA CONTRASEÑA TENGA 6 CARÁCTERES (CON NÚM, MAYUS Y MIN)

            $password = $mysqli->real_escape_string($_POST['pass']);
            $token = $mysqli->real_escape_string($_POST['token']);

            $fechaAhora = date('Y-m-d H:i:s'); //FECHA EN ESTE MOMENTO


            /* OPERACIÓN PARA OBTENER EL REGISTRO CORRESPONDIENTE AL TOKEN OBTENIDO MEDIANTE LA URL */
            $stmt = $mysqli->prepare("SELECT * FROM password_reset WHERE token=?");

            $stmt->bind_param('s', $token);

            $stmt->execute();

            $result = $stmt->get_result();

            $count = 0;
            while ($registro = $result->fetch_assoc()) {
                $count++;
                $peticion = $registro;
            }

            $stmt->close();

            if ($count != 0 && $peticion['expira'] > $fechaAhora) { //LA PETICIÓN EXISTE Y NO HA EXPIRADO TODAVÍA


                //DESACTIVAMOS EL AUTO COMMIT PARA PERMITIR TRANSACCIONES
                mysqli_autocommit($mysqli, FALSE);
                $query_success = TRUE;

                /* ACTUALIZAMOS CONTRASEÑA EN USERS USUARIOS */

                $stmt = $mysqli->prepare("UPDATE users SET password = ? WHERE id = ?");

                $encriptada = password_hash($password, PASSWORD_BCRYPT, $options); //ENCRIPTAMOS LA CONTRASEÑA

                $stmt->bind_param('si', $encriptada, $peticion['id_client']);

                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = FALSE;
                }

                $stmt->close();


                //BORRAMOS LOS REGISTROS DE ESTE USUARIO EN PASSWORD_RESET

                $stmt = $mysqli->prepare("DELETE FROM password_reset WHERE id_client = ?");

                $stmt->bind_param('i', $peticion['id_client']);

                if (!mysqli_stmt_execute($stmt)) {
                    $query_success = FALSE;
                }

                $stmt->close();

                /* PASAMOS A COMPROBAR LA TRANSACCIÓN */

                if ($query_success) { //TODO HA SALIDO CORRECTAMENTE, HACEMOS EL COMMIT
                    echo 'OK';
                    mysqli_commit($mysqli);

                } else { //NO HAN FUNCIONADO LAS DOS OPERACIONES, HACEMOS ROLLBACK
                    echo 'Error';
                    mysqli_rollback($mysqli);
                }

            } else {
                echo "expirado";
            }

        }else{
            echo "error_pass";
        }

    } else {
        echo "no_coinciden";
    }

}else{
    echo "token_necesario";
}