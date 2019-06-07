<?php

/* EN ESTE FICHERO SE AÑADIRÁN FUNCIONES QUE SE REPITAN VARIAS VECES PARA MANTENER UN ORDEN DENTRO DE CADA FICHERO */


ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//variable options, se utilizará para definir el tamaño de las contraseñas
$options = [
    'cost' => 12
];


//esta función generará una string aleatoria que luego se encriptará para obtener una contraseña
function generarContrasenya(){

    $string = "";
    $chars = "abcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $size = strlen($chars);
    for ($i = 0; $i < 8; $i++) {
        $string .= $chars[rand(0, $size - 1)];
    }
    return $string;
}

//esta función es similar a la anterior, pero realiza un random más corto, se utilizará para los nombres de las imágenes
function genRandomString()
{
    $length = 8; //longitud string
    $characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWZYZ";

    $real_string_length = strlen($characters) ;
    $string="id";

    for ($p = 0; $p < $length; $p++)
    {
        $string .= $characters[mt_rand(0, $real_string_length-1)];
    }

    return strtolower($string);
}

//se comprueba que en base a un email recibido exista o no un usuario
function noExiste($mysqli, $email){

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email = ?");

    $stmt->bind_param('s', $email);

    $stmt->execute();

    $result = $stmt->get_result();
    $count = 0;

    while($registro = $result->fetch_assoc() ){
        $count++;
        $users[] = $registro;
    }

    $stmt->close();

    if($count != 0){
        return false;
    }else{
        return true;
    }

}

//recibe un decimal y lo convierte a 00:00h
function formatearAHorasMinutos($numAConvertir){

    $cadenaFormateada = str_replace('.', ':', $numAConvertir);

    return $cadenaFormateada;
}

//al recibir las horas de la base de datos queremos realizar la conversión, ej de 5.25 a 5.15h, para ello utilizamos esta función
function formatMinutosAHTML($trabajoHoras)
{

    if ($trabajoHoras != 0) {
        if (is_float($trabajoHoras)) {

            $minutos = (int) (isset(explode('.', $trabajoHoras)[1]))
                ? explode('.', $trabajoHoras)[1]
                : $trabajoHoras;

            switch ($minutos) {
                case 0;
                    return 0;
                    break;
                case 25; // 15
                    return 15;
                    break;
                case 5; // 30
                case 50;
                    return 30;
                    break;
                case 75; // 45
                    return 45;
                    break;

            }
        }
    }
    return 0;
}

//viceversa del anterior, ej recibimos 5h:30h y lo formateamos a 5.5 para introducirlo en la base de datos
function formatMinutosABD($minutos)
{

    switch ($minutos) {
        case 15;
            return 25;
            break;
        case 3;
        case 30;
            return 50;
            break;
        case 45;
            return 75;
            break;

    }

    return 0;

}
