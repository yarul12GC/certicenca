<?php
include 'startSession.php';
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
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
        // Realizar la inserción en la base de datos
        $insertar_query = "INSERT INTO contribuyente (
        DenominacionRazonSocial,
        ClaveRFC, 
        NumProgramaIMMEX, 
        TipoDomicilio,
        CallePlanta, 
        NumeroPlanta,    
        CodigoPostal, 
        ColoniaPlanta, 
        EntidadFederativa
        ) VALUES (
        '$DenominacionRazonSocial', 
        '$ClaveRFC', 
        '$NumProgramaIMMEX', 
        '$TipoDomicilio',
        '$CallePlanta', 
        '$NumeroPlanta',    
        '$CodigoPostal', 
        '$ColoniaPlanta', 
        '$EntidadFederativa'
        )";

        if (mysqli_query($conn, $insertar_query)) {
            // Éxito al registrar
            header("Location: index.php?mensaje=exito_registro");
            exit();
        } else {
            // Error al registrar
            throw new Exception("Error al realizar la inserción en la base de datos");
        }
    } catch (Exception $e) {
        // Manejar el error sin detener la ejecución de la página
        header("Location: index.php?mensaje=error_registro");
        exit();
    }
} else {
    echo "Acceso no permitido.";
}

// Cerrar la conexión
mysqli_close($conn);
