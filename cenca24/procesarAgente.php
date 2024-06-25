<?php
include 'startSession.php';
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "conexion.php";

    $TipoAgente = $_POST["TipoAgente"];
    $NumPatenteAutorizacion = $_POST["NumPatenteAutorizacion"];
    $NombreAgenteAduanal = $_POST["NombreAgenteAduanal"];
    $ApellidoPaterno = $_POST["ApellidoPaterno"];
    $ApellidoMaterno = $_POST["ApellidoMaterno"];
    $RFC = $_POST["RFC"];
    $CURP = $_POST["CURP"];
    $ContribuyenteID = $_POST["ContribuyenteID"];
    $RazonSocial = $_POST["RazonSocial"];
    $Calle = $_POST["Calle"];
    $Numero = $_POST["Numero"];
    $CodigoPostal = $_POST["CodigoPostal"];
    $Colonia = $_POST["Colonia"];
    $EntidadFederativa = $_POST["EntidadFederativa"];
    $Pais = $_POST["Pais"];

    try {
        // Query para insertar el nuevo agente aduanal en la base de datos
        $query = "INSERT INTO agentesaduanales(TipoAgente, 
        NumPatenteAutorizacion, 
        NombreAgenteAduanal, 
        ApellidoPaterno, 
        ApellidoMaterno, 
        RFC, 
        CURP, 
        ContribuyenteID, 
        RazonSocial, 
        Calle, 
        Numero, 
        CodigoPostal, 
        Colonia, 
        EntidadFederativa, 
        Pais) 
        VALUES ('$TipoAgente', 
        '$NumPatenteAutorizacion', 
        '$NombreAgenteAduanal', 
        '$ApellidoPaterno', 
        '$ApellidoMaterno', 
        '$RFC', 
        '$CURP', 
        '$ContribuyenteID', 
        '$RazonSocial', 
        '$Calle', 
        '$Numero', 
        '$CodigoPostal', 
        '$Colonia', 
        '$EntidadFederativa', 
        '$Pais')";

        // Ejecutar la consulta
        if (mysqli_query($conn, $query)) {
            // Éxito al registrar
            header("Location: agentes.php");
            exit();
        } else {
            // Error al registrar
            throw new Exception("Error al realizar la inserción en la base de datos");
        }
    } catch (Exception $e) {
        // Manejar el error sin detener la ejecución de la página
        header("Location: agentes.php");
        exit();
    }
} else {
    echo "Acceso no permitido.";
}

// Cerrar la conexión
mysqli_close($conn);
