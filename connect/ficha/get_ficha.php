<?php

/* EN ESTE FICHERO OBTENDREMOS LOS DATOS NECESARIOS A MOSTRAR EN LA FICHA DE CADA CLIENTE */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require ('connect/BD.php');
require ('utils/myHelpers.php');

if(isset($_GET['cliente'])) {
    $id = $mysqli->real_escape_string($_GET['cliente']);
    try {

        /* CON ESTA OPERACIÓN OBTENDREMOS LA SUMA DE TODAS LOS PAQUETES, LA FECHA DE CADUCIDAD DEL ÚLTIMO PAQUETE AÑADIDO,
        LA SUMA DE TODAS LAS HORAS DEL CLIENTE EN LOS TRABAJOS, LA FOTO DE PERFIL DEL CLIENTE Y EL NOMBRE. TODO AGRUPADO POR CLIENTE*/
        $stmt = $mysqli->prepare(
            "SELECT FORMAT (SUM(horas),2) AS totalHorasPaquetes, 
                  (SELECT data_final FROM horas WHERE id_client=? ORDER BY data_final DESC LIMIT 1) AS fecha_caducidad, 
                  FORMAT ((SELECT SUM(hores) FROM items WHERE id_client=?),2) AS consumidas,
                  (SELECT perfil FROM imagenes WHERE id_client=?) AS perfil,
                  (SELECT nom FROM users WHERE id = ?) AS nom
                  FROM horas
                  WHERE id_client = ?
                  GROUP BY id_client");

        $stmt->bind_param('iiiii', $id, $id, $id, $id, $id);

        $stmt->execute();

        $result = $stmt->get_result();

        while ($registro = $result->fetch_assoc()) {
            $horasData = $registro;
        }

        $stmt->close();

        //en el caso de que nos falten datos, los dejaremos a 0

        $consumidas = 0;
        $saldo = 0;
        $totalHorasContratadas = 0;

        //si si que tenemos los datos, pasamos a realizar las operaciones necesarias
        if(isset($horasData)){
            if($horasData!=null) {

                //convertimos las horas del total de los paquetes
                $totalPaquetes = formatearNumero((float)str_replace(',', '.' ,$horasData['totalHorasPaquetes'] ));

                //convertimos las horas del total de consumidas
                $totalConsumidas = formatearNumero((float)str_replace(',', '.' ,$horasData['consumidas']));

                //obtenemos los datos necesarios

                /* HORAS CONSUMIDAS */
                $consumidas = $totalConsumidas;
                //$consumidasFuncion = str_replace('.', ':', $totalConsumidas);

                /* HORAS CONTRATADAS */
                $totalHorasContratadas = $totalPaquetes;

                /* SALDO */

                $saldoFormatoBD = $horasData['totalHorasPaquetes'] - $horasData['consumidas'];
                $saldo = formatearNumero($saldoFormatoBD);

                /* FECHAS */
                $fechaSinHoras = explode(" ", $horasData['fecha_caducidad']);
                $fecha_caducidad = date("d-m-Y", strtotime($fechaSinHoras[0]));
            }
        }

    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

//CONVERTIMOS EL NUMERO OBTENIDO DE LA BASE DE DATOS A FORMATO 'HORAS/MINUTOS'
function formatearNumero($floatAConvertir){
    $totalHoras = (int) $floatAConvertir; //extraemos el entero
    $totalMinutos = formatMinutosAHTML($floatAConvertir); //convertimos la parte decimal
    $total= (string) $totalHoras . '.' . $totalMinutos; //juntamos los números
    return $total;
}



?>