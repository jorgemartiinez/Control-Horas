<?php

/* DESDE AQUÍ AÑADIMOS UN TRABAJO A LA BASE DE DATOS, APARECERÁ COMO PENDIENTE Y SIN FECHA FINAL */

require('../BD.php');

if(isset($_POST['titulo'], $_POST['descripcion'], $_POST['cliente'])) {

    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $cliente = $mysqli->real_escape_string($_POST['cliente']);
    $fecha_inicio = date('Y-m-d H:i:s');

    //DESACTIVAMOS EL AUTO COMMIT PARA PERMITIR TRANSACCIONES
    mysqli_autocommit($mysqli, FALSE);
    $query_success = TRUE;

    //PROCEDEMOS A REALIZAR LA OPERACIÓN DE AÑADIR USUARIOS NECESARIA PARA HACER LA TRANSACCIÓN
    $stmt = $mysqli->prepare("INSERT INTO items(titulo, descripcio, id_client, data_inici) VALUES(?, ?, ?, ?)");

    $stmt->bind_param('ssis', $titulo, $descripcion, $cliente, $fecha_inicio);

    if (!mysqli_stmt_execute($stmt)) {
        $query_success = FALSE;
    }

    $stmt->close();

    if ($query_success) {
        echo "OK";
        mysqli_commit($mysqli);
    } else {
        echo "error";
        mysqli_rollback($mysqli);
    };
}
?>