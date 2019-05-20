<?php
/* DESDE ESTE FICHERO ACTUALIZAREMOS LOS REGISTROS DE LA TABLA CONFIG */

require ('../BD.php');


if($_POST) {

    $nombre = $mysqli->real_escape_string($_POST['nombre']);
    $direccion = $mysqli->real_escape_string($_POST['direccion']);
    $email = $mysqli->real_escape_string($_POST['email']);


    // EL SUBIR O NO EL LOGO ES OPCIONAL, POR LO QUE PRIMERO COMPROBAREMOS QUE EXISTA O NO PARA SABER
    // SI DEBEMOS ACTUALIZAR TODOS LOS CAMPOS Y BORRAR EL LOGO ACTUAL PARA SUBIR EL NUEVO

    if (!empty($_FILES) && isset($_FILES['logo'])) { //recibimos el logo
        try {
            require('../config.php');
            require('../../utils/myHelpers.php');
            $nombreArchivo = basename($_FILES["logo"]["name"]);
            $url_schema = parse_url($GLOBALS['config']['rutaAbsoluta']);
            $target_dir = $_SERVER["DOCUMENT_ROOT"].$url_schema['path'].'uploads/logo/';
            $explode_name = explode('.', $nombreArchivo);
            $newfilename= genRandomString().'.'.$explode_name[1];
            $target_file = $target_dir . $newfilename;
            $uploadOk = 1; //por defecto está a 1, si se produce cualquier error pasará a 0
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); //obtenemos tipo archivo

            if($_FILES["logo"]) {
                $check = getimagesize($_FILES["logo"]["tmp_name"]);
                $check = getimagesize($_FILES["logo"]["tmp_name"]);
                if($check !== false) {/*es una imagen;*/$uploadOk = 1;} else {/*echo no es una imagen*/$uploadOk = 0;}
            }

            if (file_exists($target_file)) {$uploadOk = 0; }//error
            if ($_FILES["logo"]["size"] > 500000) {echo "error_tamaño";$uploadOk = 0; }//error

            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {echo "error_formato";$uploadOk = 0;}
            if ($uploadOk == 0) {
                //echo "Lo sentimos, su imagen no ha sido subida correctamente. Inténtelo de nuevo.";
            } else {
                if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) { //la imagen se ha guardado, actualizamos en la bd



                    //QUEREMOS REALIZAR 4 UPDATES A LA VEZ, POR LO QUE HACEMOS UN CASE EN LA SENTENCIA
                    $stmt = $mysqli->prepare("UPDATE config
SET valor = CASE 
              WHEN clave = 'logo'THEN ?
              WHEN clave = 'footer-direccion'THEN ?
              WHEN clave = 'footer-empresa' THEN ? 
              WHEN clave = 'footer-email' THEN ? 
         END
WHERE clave IN ('logo','footer-direccion','footer-empresa','footer-email')");

                    $stmt->bind_param('ssss', $newfilename,$direccion, $nombre, $email);

                    if ($stmt->execute()) { //se actualiza correctamente, ahora procedemos a guardar el logo y la info en sesión
                        session_start();
                        if ($_SESSION['config']['logo'] != 'logo-light.png') {
                            unlink($target_dir . $_SESSION['config']['logo']); //se borra la anterior
                            $_SESSION['config']['logo'] = $newfilename; // se actualiza la variable de sesión con el nuevo nombre de la imagen
                        } else {
                            $_SESSION['config']['logo'] = $newfilename;
                        }

                        $_SESSION['config']['footer-empresa'] = $nombre;
                        $_SESSION['config']['footer-direccion'] = $direccion;
                        $_SESSION['config']['footer-email'] = $email;

                        echo "OK";
                    } else {
                        echo "Ha habido un error subiendo su imagen. Inténtelo de nuevo.";
                    }
                    $stmt->close();
                }else {
                    echo "Ha habido un error subiendo su imagen. Inténtelo de nuevo.";
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    } else { // NO SE RECIBE LA IMAGEN
        try {

            //CASE
            $stmt = $mysqli->prepare("UPDATE config
SET valor = CASE 
              WHEN clave = 'footer-direccion'THEN ?
              WHEN clave = 'footer-empresa' THEN ? 
              WHEN clave = 'footer-email' THEN ? 
         END
WHERE clave IN ('footer-direccion','footer-empresa','footer-email')");

            $stmt->bind_param('sss', $direccion,$nombre , $email);

            if ($stmt->execute()) {
                echo "OK";
                session_start(); /* SE ACTUALIZA LA INFO DE SESIÓN */
                $_SESSION['config']['footer-empresa'] = $nombre;
                $_SESSION['config']['footer-direccion'] = $direccion;
                $_SESSION['config']['footer-email'] = $email;
            }
            $stmt->close();

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}