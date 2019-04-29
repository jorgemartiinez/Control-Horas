<?php
/* OBTENEMOS LOS DATOS DE LA TABLA CONFIG (POR AHORA SON DATOS FOOTER Y LOGO)*/

require ('connect/BD.php');

try {

    /* OBTENEMOS TODOS LOS REGISTROS DE LA TABLA */
    $stmt = $mysqli->prepare("SELECT * FROM config");

    if($stmt->execute()){
        $result = $stmt->get_result();

        while ($registro = $result->fetch_assoc()) {
            /* A DIFERENCIA DE LOS DEMÁS SELECTS DE LA APLICACIÓN ESTE TIENE UN FORMATO DIFERENTE, POR LO QUE LO VAMOS A FORMATEAR PARA OBTENER UNO SIMILAR*/
            $_SESSION['config'][$registro['clave']] = $registro['valor'];
        }

    }else{
        echo "Error al obtener configuración";
    }

    $stmt->close();

} catch (Exception $e) {
    echo $e->getMessage();
}
