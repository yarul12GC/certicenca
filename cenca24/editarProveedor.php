<?php
include 'startSession.php';
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $ProveedorID = $_POST['ProveedorID'];
    $NumClaveIdentificacionEmpresa = $_POST['NumClaveIdentificacionEmpresa'];
    $NombreRazonSocial = $_POST['NombreRazonSocial'];
    $Nacionalidad = $_POST['Nacionalidad'];
    $NumProgramaIMMEX = isset($_POST['NumProgramaIMMEX']) ? $_POST['NumProgramaIMMEX'] : null;
    $RecintoFiscalizado = isset($_POST['RecintoFiscalizado']) ? $_POST['RecintoFiscalizado'] : null;
    $ClaveIdentificacionFiscal = isset($_POST['ClaveIdentificacionFiscal']) ? $_POST['ClaveIdentificacionFiscal'] : null;
    $Calle = $_POST['Calle'];
    $Numero = $_POST['Numero'];
    $CodigoPostal = $_POST['CodigoPostal'];
    $Colonia = $_POST['Colonia'];
    $EntidadFederativa = $_POST['EntidadFederativa'];
    $Pais = $_POST['Pais'];
    $ContribuyenteID = $_POST['ContribuyenteID'];

    try {
        // Realizar la actualización en la base de datos
        $actualizar_query = "UPDATE proveedores SET
            NumClaveIdentificacionEmpresa = '$NumClaveIdentificacionEmpresa',
            NombreRazonSocial = '$NombreRazonSocial',
            Nacionalidad = '$Nacionalidad',
            NumProgramaIMMEX = '$NumProgramaIMMEX',
            RecintoFiscalizado = '$RecintoFiscalizado',
            ClaveIdentificacionFiscal = '$ClaveIdentificacionFiscal',
            Calle = '$Calle',
            Numero = '$Numero',
            CodigoPostal = '$CodigoPostal',
            Colonia = '$Colonia',
            EntidadFederativa = '$EntidadFederativa',
            Pais = '$Pais',
            ContribuyenteID = '$ContribuyenteID'
            WHERE ProveedorID = $ProveedorID";

        if (mysqli_query($conn, $actualizar_query)) {
            // Éxito al actualizar
            header("Location: proveedores.php?mensaje=exito");
            exit();
        } else {
            // Error al actualizar
            throw new Exception("Error al realizar la actualización en la base de datos");
        }
    } catch (Exception $e) {
        // Manejar el error sin detener la ejecución de la página
        header("Location: proveedores.php?mensaje=error");
        exit();
    }
} else {
    echo "Acceso no permitido.";
}
