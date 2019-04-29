<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require('../BD.php');

if(isset($_POST['horas'], $_POST['cliente'], $_POST['meses'])) { //COMPROBAMOS QUE RECIBIMOS TODOS LOS DATOS Y MEDIANTE POST

    $horas = $mysqli->real_escape_string($_POST['horas']);
    $cliente= $mysqli->real_escape_string($_POST['cliente']);
    $meses= $mysqli->real_escape_string($_POST['meses']);

    $data_inicio =  date('Y-m-d H:i:s');
    $data_final = date('Y-m-d H:i:s', strtotime("+". $meses ."months"));


    //DESACTIVAMOS EL AUTO COMMIT PARA PERMITIR TRANSACCIONES
    mysqli_autocommit($mysqli, FALSE);
    $query_success = TRUE;

    /* INSERTAMOS EL NUEVO PAQUETE EN LA TABLA HORAS */

    $stmt = $mysqli->prepare("INSERT INTO horas(id_client, horas, data_inici, data_final) VALUES(?, ?, ?, ?)");

    $stmt->bind_param('iiss', $cliente, $horas, $data_inicio, $data_final);


    if (!mysqli_stmt_execute($stmt)) {
        $query_success = FALSE;
    }

    $stmt->close();


    if($query_success){ //SI LA TRANSACCIÓN ES CORRECTA, PROCEDEREMOS A ENVIAR EL CORREO

        echo "OK";
        mysqli_commit($mysqli);

        require_once("../../utils/enviarCorreo.php");

        try {

            $clientePaquete = getCliente($cliente, $mysqli);

            $dataFormateada = date( "m/d/Y", strtotime($data_final));

            enviarCorreoNuevoPaquete('Paquete horas adquirido',
                $clientePaquete['email'],
                $clientePaquete['nom'], 'nuevo_paquete',
                $horas, $dataFormateada
            );


        } catch (phpmailerException $e) {
            echo $e->errorMessage();
        } catch (Exception $e) {
            echo $e->getMessage();
        }


    }else{
        echo "error";
        mysqli_rollback($mysqli);
    };

}


//FUNCIÓN PARA OBTENER UN CLIENTE EN BASE A UNA ID
function getCliente($id, $mysqli){

    $stmt = $mysqli->prepare(
        "SELECT * FROM users WHERE id=?");

    $stmt->bind_param('i', $id);

    $stmt->execute();

    $result = $stmt->get_result();

    while ($registro = $result->fetch_assoc()) {
        $cliente = $registro;
    }

    return $cliente;

}
?>
