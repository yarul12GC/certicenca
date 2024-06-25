<?php
include 'startSession.php';
require 'conexion.php';

if (isset($_POST['aduana_salida_id'])) {
    // Obtener el ID de la aduana de salida
    $aduana_salida_id = $_POST['aduana_salida_id'];

    // Realizar la eliminación en la base de datos
    $eliminar_query = "DELETE FROM aduanasalidas WHERE AduanaSalidaID = '$aduana_salida_id'";

    // Ejecutar la consulta de eliminación
    if (mysqli_query($conn, $eliminar_query)) {
        header("Location: infoaduanera.php");
    } else {
        echo "Error al eliminar el registro: " . mysqli_error($conn);
    }
} else {
    echo "No se recibió el ID de la aduana de salida.";
}
?>
