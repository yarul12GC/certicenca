<?php
include 'startSession.php';
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "conexion.php";

    $NumeroPedimento = $_POST["NumeroPedimento"];
    $ClaveAduana = $_POST["ClaveAduana"];
    $patente = $_POST["patente"];
    $NumeroDoc = $_POST["NumeroDoc"];
    $FechaPedimento = $_POST["FechaPedimento"];
    $ClavePedimento = $_POST["ClavePedimento"];
    $ContribuyenteID = $_POST["ContribuyenteID"];
    $PaisOrigen = $_POST["PaisOrigen"];
    $TipoImpuesto = $_POST["TipoImpuesto"];
    $TasaDeImpuesto = $_POST["TasaDeImpuesto"];
    $GuiaAereaConocimientoEmbarque = $_POST["GuiaAereaConocimientoEmbarque"];
    $FacturaComercial = $_POST["FacturaComercial"];
    $AvisoElectronico = $_POST["AvisoElectronicoImportacionExportacion"];
    $FechaCruce = $_POST["FechaCruceAviso"];
    $SubmanufacturaID = $_POST["ActivoFijoID"];

    try {
        $query = "INSERT INTO aduanaactivosfijos (NumeroPedimento, 
        ClaveAduana, 
        patente, 
        NumeroDoc, 
        FechaPedimento, 
        ClavePedimento,
        PaisOrigen, 
        ActivoFijoID, 
        TipoImpuesto, 
        TasaDeImpuesto, 
        GuiaAereaConocimientoEmbarque, 
        FacturaComercial, 
        ContribuyenteId, 
        AvisoElectronicoImportacionExportacion, 
        FechaCruceAviso) 
        VALUES ('$NumeroPedimento', 
        '$ClaveAduana', 
        '$patente', 
        '$NumeroDoc', 
        '$FechaPedimento',
        '$ClavePedimento', 
        '$PaisOrigen', 
        '$SubmanufacturaID', 
        '$TipoImpuesto', 
        '$TasaDeImpuesto', 
        '$GuiaAereaConocimientoEmbarque', 
        '$FacturaComercial', 
        '$ContribuyenteID', 
        '$AvisoElectronico', 
        '$FechaCruce')";


        // Ejecutar la consulta
        if (mysqli_query($conn, $query)) {
            // Éxito al registrar
            header("Location: aduanasActivo.php");
            exit();
        } else {
            // Error al registrar
            throw new Exception("Error al realizar la inserción en la base de datos");
        }
    } catch (Exception $e) {
        // Manejar el error sin detener la ejecución de la página
        header("Location: aduanasActivo.php");
        exit();
    }
} else {
    echo "Acceso no permitido.";
}

// Cerrar la conexión
mysqli_close($conn);
