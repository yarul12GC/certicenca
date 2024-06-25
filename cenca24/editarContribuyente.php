<?php
include 'startSession.php';
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $ContribuyenteID = $_POST['ContribuyenteID'];
    $DenominacionRazonSocial = $_POST['DenominacionRazonSocial'];
    $ClaveRFC = $_POST['ClaveRFC'];
    $NumProgramaIMMEX = $_POST['NumProgramaIMMEX'];
    $TipoDomicilio = $_POST['TipoDomicilio'];
    $CallePlanta = $_POST['CallePlanta'];
    $NumeroPlanta = $_POST['NumeroPlanta'];
    $CodigoPostal = $_POST['CodigoPostal'];
    $ColoniaPlanta = $_POST['ColoniaPlanta'];
    $EntidadFederativa = $_POST['EntidadFederativa'];

    try {
        // Realizar la actualización en la base de datos
        $actualizar_query = "UPDATE contribuyente SET
            DenominacionRazonSocial = '$DenominacionRazonSocial',
            ClaveRFC = '$ClaveRFC',
            NumProgramaIMMEX = '$NumProgramaIMMEX',
            TipoDomicilio = '$TipoDomicilio',
            CallePlanta = '$CallePlanta',
            NumeroPlanta = '$NumeroPlanta',
            CodigoPostal = '$CodigoPostal',
            ColoniaPlanta = '$ColoniaPlanta',
            EntidadFederativa = '$EntidadFederativa'
            WHERE ContribuyenteID = $ContribuyenteID";

        if (mysqli_query($conn, $actualizar_query)) {
            // Éxito al actualizar
            header("Location: index.php?mensaje=exito");
            exit();
        } else {
            // Error al actualizar
            throw new Exception("Error al realizar la actualización en la base de datos");
        }
    } catch (Exception $e) {
        // Manejar el error sin detener la ejecución de la página, todo este codigo se hace en caso de que falle la bd no detenga la pagina y solo nos made el error en mensaje 
        header("Location: index.php?mensaje=error");
        exit();
    }
} else {
    echo "Acceso no permitido.";
}

// Cerrar la conexión
mysqli_close($conn);
