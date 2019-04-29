<?php

/* ESTE FICHERO SERVIRÁ PARA ACTUALIZAR LA FOTO DE LOS USUARIOS TANTO DESDE PERFIL
EN LA PARTE DE CLIENTE COMO DESDE CLIENTES EN LA PARTE DE ADMINISTRACIÓN,
HABRÁ UNA IMAGEN POR USUARIO, POR LO QUE SI SUBES UNA SE BORRARÁ LA ANTERIOR Y SE SUBIRÁ LA NUEVA */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../../utils/myHelpers.php');
require('../BD.php');

$nombreArchivo = basename($_FILES["subida"]["name"]);

require('../config.php');

//RUTAS
$url_schema = parse_url($GLOBALS['config']['rutaAbsoluta']);
$target_dir = $_SERVER["DOCUMENT_ROOT"].$url_schema['path'].'uploads/perfil/';

//CREAMOS NOMBRE ARCHIVO, RANDOM Y CON SU EXTENSIÓN ORIGINAL
$explode_name = explode('.', $nombreArchivo);
$newfilename= genRandomString().'.'.$explode_name[1];

$target_file = $target_dir . $newfilename;
$uploadOk = 1; //por defecto está a 1, si se produce cualquier error pasará a 0
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION)); //obtenemos tipo archivo


// Se comprueba que el usuario haya subido una imagen
if($_FILES["subida"]) {
    $check = getimagesize($_FILES["subida"]["tmp_name"]);
    $check = getimagesize($_FILES["subida"]["tmp_name"]);
    if($check !== false) {
        //es una imagen;
        $uploadOk = 1;
    } else {
        //echo "no es una imagen";
        $uploadOk = 0; //no es una imagen, error
    }
}

// Se comprueba si la imagen existe
if (file_exists($target_file)) {
    $uploadOk = 0; //error
}
// Se comprueba el tamaño del archivo
if ($_FILES["subida"]["size"] > 500000) {
    echo "error_tamaño";
    $uploadOk = 0; //error
}
// Se comprueba que el archivo sea de la extensión indicada
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo "error_formato";
    $uploadOk = 0; //error
}
// Si uploadOK esta a 0 significa que no se habrá subido la imagen
if ($uploadOk == 0) {
    //echo "Lo sentimos, su imagen no ha sido subida correctamente. Inténtelo de nuevo.";

// Si uploadOK 1 significa que se intentará subir la imagen
} else {

    if (move_uploaded_file($_FILES["subida"]["tmp_name"], $target_file)) {
        //echo "La imagen ". basename( $_FILES["subida"]["name"]). " ha sido subida correctamente.";
        session_start();

        $id_client = null;

        //comprobamos si la id la recibimos desde un usuario que intenta editar su perfil o de un admin que intenta editar la imagen de un usuario
        if(!isset($_POST['client'])){
            $id_client = $_SESSION['usuario']['id'];
        }else{
            $id_client = $_POST['client'];
            $urlPerfilCliente = getURLPhotoCliente($mysqli, $id_client);
        }


        /* SE ACTUALIZA EL NOMBRE DE LA IMAGEN DE PERFIL EN LA TABLA IMÁGENES */

        $stmt =$mysqli->prepare("UPDATE imagenes SET perfil = ? WHERE id_client = ?");

        $stmt->bind_param('si',$newfilename , $id_client);

        if($stmt->execute()){
            echo "OK";

            /* SE GUARDA LA IMAGEN Y SE BORRA LA ANTERIOR, A EXCEPCIÓN DE SI ES LA IMAGEN POR DEFECTO */
            /* ADEMÁS, SI NO HEMOS RECIBIDO EL PARÁMETRO CLIENT SIGNIFICA QUE NO HABRÁ QUE GUARDARLA EN SESIÓN
            YA QUE EL CAMBIO NO SE ESTARÁ REALIZANDO DESDE PERFIL, SI LO HEMOS RECIBIDO SI LA GUARDAREMOS */

            if(!isset($_POST['client'])) {
                if($_SESSION['usuario']['perfil']!='user-default.png') {
                    unlink($target_dir .$_SESSION['usuario']['perfil']); //se borra la anterior
                    $_SESSION['usuario']['perfil'] = $newfilename; // se actualiza la variable de sesión con el nuevo nombre de la imagen
                }else{
                    $_SESSION['usuario']['perfil'] = $newfilename;
                }
            }else{
                if($urlPerfilCliente!='user-default.png') {
                    unlink($target_dir .$urlPerfilCliente); // se borra la anterior
                }
            }

        }else{
            echo "Ha habido un error subiendo su imagen. Inténtelo de nuevo.";
        };

    } else {
        echo "Ha habido un error subiendo su imagen. Inténtelo de nuevo.";
    }
}


/* OBTENEMOS EL NOMBRE DE LA FOTO DE PERFIL ACTUAL DE ESE CLIENTE */
function getURLPhotoCliente($mysqli, $client){

    $stmt = $mysqli->prepare(
        "SELECT imagenes.perfil FROM imagenes WHERE id_client=?");

    $stmt->bind_param('i', $client);

    $stmt->execute();

    $result = $stmt->get_result();

    while ($registro = $result->fetch_assoc()) {
        $resultado = $registro;
    }

    return $resultado['perfil'];
}

exit();
?>