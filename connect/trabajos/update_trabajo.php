<?php

/* DESDE AQUÍ ACTUALIZAREMOS UN TRABAJO */

ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require('../BD.php');

require('../../utils/myHelpers.php');

if(isset($_POST['titulo'], $_POST['descripcion'], $_POST['cliente'], $_POST['trabajo'], $_POST['fin'] )) {

    $titulo= $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $cliente = $mysqli->real_escape_string($_POST['cliente']);
    $trabajo = $mysqli->real_escape_string($_POST['trabajo']);
    $fin = $mysqli->real_escape_string($_POST['fin']);
    $horas = $mysqli->real_escape_string($_POST['horas']);

    $minutos = $mysqli->real_escape_string($_POST['minutos']);

    $minutosFinal = formatMinutosABD($minutos);

    $horasFinal = (float) $horas . '.' . $minutosFinal;

    //DESACTIVAMOS EL AUTO COMMIT PARA PERMITIR TRANSACCIONES
    mysqli_autocommit($mysqli, FALSE);


    if($fin == 'si'){ //si recibimos este parámetro significará que debemos dar por concluído el trabajo, por lo que añadiremos las horas finales y su fecha final

        $fecha_final = date('Y-m-d H:i:s');

        try {
            $query_success = TRUE;

            $stmt = $mysqli->prepare("UPDATE items SET titulo = ?, descripcio = ?, id_client = ?, data_final = ?, hores = ?  WHERE id = ?");

            $stmt->bind_param('ssisdi', $titulo, $descripcion, $cliente, $fecha_final, $horasFinal, $trabajo);

            if (!mysqli_stmt_execute($stmt)) {
                $query_success = FALSE;
            }

            $stmt->close();

            if ($query_success) { //transacción correcta, pasamos a enviar el correo

                echo "OK";
                mysqli_commit($mysqli);

                require_once("../../utils/enviarCorreo.php");

                $clienteTrabajo = getCliente($trabajo, $mysqli);
                $duracion = $horas . ':' . $minutos . 'h';

                enviarCorreoTareaCompletada('Tarea Completada',
                    $clienteTrabajo['email'],
                    $clienteTrabajo['nom'], 'tarea_completada',
                    $clienteTrabajo['titulo'], $clienteTrabajo['descripcio'], $duracion
                );

            } else {
                echo "Error";
                mysqli_rollback($mysqli);
            };

        } catch (Exception $e) {
            echo $e->getMessage();
        }


    }else { //si todavía no hay que marcarlo como completado no guardaremos sus horas y fecha final ni enviaremos el correo todavía

        try {
            $query_success = TRUE;


            $stmt = $mysqli->prepare("UPDATE items SET titulo = ?, descripcio = ?, id_client = ?,  hores = ?  WHERE id = ?");

            $stmt->bind_param('ssidi', $titulo, $descripcion, $cliente, $horasFinal, $trabajo);

            if (!mysqli_stmt_execute($stmt)) {
                $query_success = FALSE;
            }

            $stmt->close();

            if ($query_success) { //update succeed, commit
                echo "OK";
                mysqli_commit($mysqli);
            } else { //error, rollback
                echo "Error";
                mysqli_rollback($mysqli);
            };


        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}


/* FUNCIÓN PARA OBTENER EL CLIENTE ASOCIADO AL TRABAJO */

function getCliente($id, $mysqli){

    $stmt = $mysqli->prepare(
        "SELECT users.nom, users.email, items.titulo, items.descripcio 
         FROM items 
         LEFT JOIN users 
         ON items.id_client = users.id
         WHERE items.id=?");

    $stmt->bind_param('i', $id);

    $stmt->execute();

    $result = $stmt->get_result();

    while ($registro = $result->fetch_assoc()) {
        $cliente = $registro;
    }

    return $cliente;

}