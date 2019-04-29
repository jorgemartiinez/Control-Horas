<?php

//DESACTIVAMOS EL AUTO COMMIT PARA PERMITIR TRANSACCIONES
mysqli_autocommit($mysqli, FALSE);
$query_success = TRUE;


/* INSERTAMOS USUARIO */
$stmt = $mysqli->prepare("INSERT INTO users(nom, rol, email, data_alta, password) VALUES(?, ?, ?, ?, ?)");

$stmt->bind_param('sisss', $nombre,$rol ,$email, $fecha_alta, $encriptada);

if (!mysqli_stmt_execute($stmt)) {
    $query_success = FALSE;
}
$id_cliente = $stmt->insert_id;

$stmt->close();

/* IMAGEN POR DEFECTO */
$stmt = $mysqli->prepare("INSERT INTO imagenes (id_client) VALUES(?)");

$stmt->bind_param('i', $id_cliente);
if (!mysqli_stmt_execute($stmt)) {
    $query_success = FALSE;
}

$stmt->close();

if ($query_success) {
    echo 'OK';
    mysqli_commit($mysqli);
}else{
    echo 'Error';
    mysqli_rollback($mysqli);
}
