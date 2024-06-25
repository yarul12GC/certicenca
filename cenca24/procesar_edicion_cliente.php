<?php
include 'startSession.php';
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $ClienteID = $_POST['ClienteID'];
    $NumClaveIdentificacion = $_POST['NumClaveIdentificacion'];
    $NombreRazonSocial = $_POST['NombreRazonSocial'];
    $Nacionalidad = $_POST['Nacionalidad'];
    $NumProgramaIMMEX = $_POST['NumProgramaIMMEX'];
    $ECEX = $_POST['ECEX'];
    $EmpresaIndustrial = $_POST['EmpresaIndustrial'];
    $RecintoFiscalizado = $_POST['RecintoFiscalizado'];
    $ClaveIdentificacionFiscal = $_POST['ClaveIdentificacionFiscal'];
    $Calle = $_POST['Calle'];
    $Numero = $_POST['Numero'];
    $CodigoPostal = $_POST['CodigoPostal'];
    $Colonia = $_POST['Colonia'];
    $EntidadFederativa = $_POST['EntidadFederativa'];
    $Pais = $_POST['Pais'];
    $ContribuyenteID = $_POST['ContribuyenteID'];

    try {
        // Realizar la actualización en la base de datos
        $actualizar_query = "UPDATE clientes SET
            NumClaveIdentificacion = '$NumClaveIdentificacion',
            NombreRazonSocial = '$NombreRazonSocial',
            Nacionalidad = '$Nacionalidad',
            NumProgramaIMMEX = '$NumProgramaIMMEX',
            ECEX = '$ECEX',
            EmpresaIndustrial = '$EmpresaIndustrial',
            RecintoFiscalizado = '$RecintoFiscalizado',
            ClaveIdentificacionFiscal = '$ClaveIdentificacionFiscal',
            Calle = '$Calle',
            Numero = '$Numero',
            CodigoPostal = '$CodigoPostal',
            Colonia = '$Colonia',
            EntidadFederativa = '$EntidadFederativa',
            Pais = '$Pais',
            ContribuyenteID = '$ContribuyenteID'
            WHERE ClienteID = '$ClienteID'";

        if (mysqli_query($conn, $actualizar_query)) {
            // Éxito al actualizar
            header("Location: cliente.php?mensaje=exito");
            exit();
        } else {
            // Error al actualizar
            throw new Exception("Error al realizar la actualización en la base de datos");
        }
    } catch (Exception $e) {
        // Manejar el error sin detener la ejecución de la página
        header("Location: cliente.php?mensaje=error");
        exit();
    }
} else {
    // Aquí está bien, solo hay un echo en caso de acceso no permitido.
    echo "Acceso no permitido.";
}

// Cerrar la conexión
mysqli_close($conn);
?>
