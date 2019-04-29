<?php
/* DESDE AQUÍ ACTUALIZAREMOS INFORMACIÓN PERSONAL DE LOS USUARIOS */
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require ('../BD.php');
require ('../../utils/myHelpers.php');

if(isset($_POST['nombre'],$_POST['email'])) {

    $nombre = $mysqli->real_escape_string($_POST['nombre']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $sesion = $mysqli->real_escape_string($_POST['sesion']);

    try {


        if(isset($_POST['rol'])) { //si recibimos el rol lo actualizaremos también, cómo es el caso de las tablas de admin y clientes
            $id = $mysqli->real_escape_string($_POST['id']);

            $rol = $mysqli->real_escape_string($_POST['rol']);

            /* REALIZAMOS EL UPDATE */
            $stmt = $mysqli->prepare("UPDATE users SET nom = ?, email = ?, rol = ? WHERE id = ?");

            $stmt->bind_param('ssii', $nombre, $email, $rol, $id);

        }else{//si no recibimos el rol, entonces querrá decir que el usuario estará actualizando información desde su perfil

            session_start();
            $id = $_SESSION['usuario']['id'];

            /* REALIZAMOS EL UPDATE */
            $stmt = $mysqli->prepare("UPDATE users SET nom = ?, email = ? WHERE id = ?");

            $stmt->bind_param('ssi', $nombre, $email, $id);

        }

        if ($stmt->execute()) {

            if ( $sesion == 1) { //si sesión es 1 actualizamos la información en sesión, ya que vendrá desde el perfil
                session_start();
                $_SESSION['usuario']['nom'] = $nombre;
                $_SESSION['usuario']['email'] = $email;
            }

            echo "OK";
        } else {
            echo "Error";
        };

        $stmt->close();

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

