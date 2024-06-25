<?php
include 'startSession.php';
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "conexion.php";

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
        // Query para insertar el nuevo material en la base de datos
        $query =
            "INSERT INTO clientes (NumClaveIdentificacion, 
            NombreRazonSocial, 
            Nacionalidad, 
            NumProgramaIMMEX, 
            ECEX, 
            EmpresaIndustrial, 
            RecintoFiscalizado, 
            ClaveIdentificacionFiscal, 
            Calle, 
            Numero, 
            CodigoPostal, 
            Colonia, 
            EntidadFederativa, 
            Pais, 
            ContribuyenteID) 
            VALUES ('$NumClaveIdentificacion', 
            '$NombreRazonSocial', 
            '$Nacionalidad', 
            '$NumProgramaIMMEX', 
            '$ECEX', 
            '$EmpresaIndustrial', 
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
            header("Location:cliente.php?mensaje=exito_registro");
            exit();
        } else {
            // Error al registrar
            throw new Exception("Error al realizar la inserción en la base de datos");
        }
    } catch (Exception $e) {
        // Manejar el error sin detener la ejecución de la página
        header("Location: cliente.php?mensaje=error_registro");
        exit();
    }
} else {
    // Aquí está bien, solo hay un echo en caso de acceso no permitido.
    echo "Acceso no permitido.";
}

// Cerrar la conexión
mysqli_close($conn);
?>
