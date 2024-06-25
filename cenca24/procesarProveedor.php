<?php
include 'startSession.php';
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "conexion.php";

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
        // Query para insertar el nuevo material en la base de datos
        $query =
            "INSERT INTO proveedores (NumClaveIdentificacionEmpresa, 
        NombreRazonSocial, 
        Nacionalidad, 
        NumProgramaIMMEX, 
        RecintoFiscalizado, 
        ClaveIdentificacionFiscal, 
        Calle, 
        Numero, 
        CodigoPostal, 
        Colonia, 
        EntidadFederativa, 
        Pais, 
        ContribuyenteID) VALUES ('$NumClaveIdentificacionEmpresa', 
        '$NombreRazonSocial', 
        '$Nacionalidad', 
        '$NumProgramaIMMEX', 
        '$RecintoFiscalizado', 
        '$ClaveIdentificacionFiscal', 
        '$Calle', 
        '$Numero', 
        '$CodigoPostal', 
        '$Colonia', 
        '$EntidadFederativa', 
        '$Pais', 
        '$ContribuyenteID')";

        // Ejecutar la consulta
        if (mysqli_query($conn, $query)) {
            // Éxito al registrar
            header("Location: proveedores.php?mensaje=exito_registro");
            exit();
        } else {
            // Error al registrar
            throw new Exception("Error al realizar la inserción en la base de datos");
        }
    } catch (Exception $e) {
        // Manejar el error sin detener la ejecución de la página
        header("Location: proveedores.php?mensaje=error_registro");
        exit();
    }
} else {
    echo "Acceso no permitido.";
}

// Cerrar la conexión
mysqli_close($conn);
