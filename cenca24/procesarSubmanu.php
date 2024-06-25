<?php
include 'startSession.php';
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $NumClaveIdentificacion = $_POST['NumClaveIdentificacion'];
    $NombreRazonSocial = $_POST['NombreRazonSocial'];
    $NumAutorizacionSE = $_POST['NumAutorizacionSE'];
    $FechaAutorizacion = $_POST['FechaAutorizacion'];
    $Calle = $_POST['Calle'];
    $Numero = $_POST['Numero'];
    $CodigoPostal = $_POST['CodigoPostal'];
    $Colonia = $_POST['Colonia'];
    $EntidadFederativa = $_POST['EntidadFederativa'];
    $Pais = $_POST['Pais'];
    $ContribuyenteID = $_POST['ContribuyenteID'];

    try {
        // Realizar la inserción en la base de datos
        $insertar_query = "INSERT INTO submanufactura (
            NumClaveIdentificacion,
            NombreRazonSocial, 
            NumAutorizacionSE,
            FechaAutorizacion,
            Calle, 
            Numero,    
            CodigoPostal, 
            Colonia, 
            EntidadFederativa, 
            Pais, 
            ContribuyenteID
        ) VALUES (
            '$NumClaveIdentificacion', 
            '$NombreRazonSocial', 
            '$NumAutorizacionSE',
            '$FechaAutorizacion',
            '$Calle', 
            '$Numero',    
            '$CodigoPostal', 
            '$Colonia', 
            '$EntidadFederativa', 
            '$Pais', 
            '$ContribuyenteID'
        )";

        if (mysqli_query($conn, $insertar_query)) {
            // Éxito al registrar
            header("Location: submanufactura.php?mensaje=exito_registro");
            exit();
        } else {
            // Error al registrar
            throw new Exception("Error al realizar la inserción en la base de datos");
        }
    } catch (Exception $e) {
        // Manejar el error sin detener la ejecución de la página
        header("Location: submanufactura.php?mensaje=error_registro");
        exit();
    }
} else {
    echo "Acceso no permitido.";
}

// Cerrar la conexión
mysqli_close($conn);
