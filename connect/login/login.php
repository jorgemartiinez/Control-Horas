<?php

/*
DESDE ESTE FICHERO REALIZAREMOS EL LOGIN EN NUESTRA APLICACIÓN,
PARA ELLO OBTENDREMOS EL USUARIO Y LO GUARDAREMOS EN SESIÓN
*/

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require '../BD.php';


if(isset($_POST['email'], $_POST['password'])) {

    $email = $mysqli->real_escape_string($_POST['email']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $resultado = null;

    try {

        //NECESITAMOS COMPROBAR QUE EXISTA EL USUARIO Y SUS DATOS ESTÉN BIEN PARA GUARDARLOS EN SESIÓN


        /* REALIZAMOS LA QUERY PARA OBTENER EL USUARIO */
        $stmt = $mysqli->prepare("SELECT users.id, users.nom, users.rol, users.estado, users.email, 
users.data_alta, users.password, imagenes.perfil
FROM users 
INNER JOIN imagenes
ON imagenes.id_client = users.id 
WHERE email=?");

        $stmt->bind_param('s', $email);

        $stmt->execute();

        $result = $stmt->get_result();

        while ($registro = $result->fetch_assoc()) {
            $resultado = $registro;
        }

        $stmt->close();

    } catch (Exception $e) {
        echo $e->getMessage();
    }

    if (isset($resultado) && count($resultado)) { // SI NOS DEVUELVE UN REGISTRO SIGNIFICA QUE EL USUARIO EXISTE, PASAMOS A VALIDAR SUS DATOS

        if ($resultado['estado']) { //SI SU CUENTA ESTÁ ACTIVADA

            if (!comprobarPassword($resultado, $email, $password)) { //COMPROBAMOS LA CONTRASEÑA
                echo "error_pass";
            } else  {
                echo 'OK';

                /* GUARDAMOS VARIABLES EN SESIÓN */
                session_start();

                //guardamos en la clave usuario el resultado de la query
                $_SESSION['usuario'] = $resultado;

                //ESTAS VARIABLES LAS GUARDAMOS PARA EVITAR LA SUPLANTACIÓN DE SESIONES,
                // SE HARÁ UNA COMPROBACIÓN EN EL HEADER DE LA PÁGINA
                $_SESSION['REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];
                $_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];

                /* SESIONES PARA CERRAR SESIÓN POR INACTIVIDAD */
                $_SESSION['last_activity'] = time(); //la última actividad se ha producido ahora, al hacer login.
                $_SESSION['expire_time'] = 2700; //tiempo que tardará en expirar la sesión en segundos
                $_SESSION['expired'] = 0;
            }

        } else {
            echo "error_estado";
        }
    } else {
        echo "error_no_existe";
    }
}


//FUNCIÓN DE COMPROBAR LA CONTRASEÑA, SE UTILIZA PASSWORD_VERIFY PARA LA COMPROBACIÓN, YA QUE LOS DATOS ESTÁN ENCRIPTADOS
function comprobarPassword($resultado, $email, $password)
{
    if ($email == $resultado['email'] && !password_verify($password, $resultado['password'])) { //SI LA CONTRASEÑA ES CORRECTA
        return false;
    }else { //SI NO ES CORRECTA
        return true;
    }
}
?>