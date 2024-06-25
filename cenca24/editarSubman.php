<?php
include 'startSession.php';
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $SubmanufacturaID = $_POST["SubmanufacturaID"];
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
        // Realizar la actualización en la base de datos
        $actualizar_query = "UPDATE submanufactura SET
            NumClaveIdentificacion = '$NumClaveIdentificacion',
            NombreRazonSocial = '$NombreRazonSocial',
            NumAutorizacionSE = '$NumAutorizacionSE',
            FechaAutorizacion = '$FechaAutorizacion',
            Calle = '$Calle',
            Numero = '$Numero',
            CodigoPostal = '$CodigoPostal',
            EntidadFederativa = '$EntidadFederativa',
            Pais = '$Pais',
            ContribuyenteID = '$ContribuyenteID'
            WHERE SubmanufacturaID = $SubmanufacturaID";

        if (mysqli_query($conn, $actualizar_query)) {
            // Éxito al actualizar
            header("Location: submanufactura.php?mensaje=exito");
            exit();
        } else {
            // Error al actualizar
            throw new Exception("Error al realizar la actualización en la base de datos");
        }
    } catch (Exception $e) {
        // Manejar el error sin detener la ejecución de la página
        header("Location: submanufactura.php?mensaje=error");
        exit();
    }
} else {
    echo "Acceso no permitido.";
}
