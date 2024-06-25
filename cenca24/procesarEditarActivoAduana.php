<?php
include 'startSession.php';
require 'conexion.php'; // Incluir el archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $IdActivoFijo = $_POST['IdActivoFijo'];
    $NumeroPedimento = $_POST['NumeroPedimento'];
    $ClaveAduana = $_POST['ClaveAduana'];
    $patente = $_POST['patente'];
    $NumeroDoc = $_POST['NumeroDoc'];
    $FechaPedimento = $_POST['FechaPedimento'];
    $ClavePedimento = $_POST['ClavePedimento'];
    $PaisOrigen = $_POST['PaisOrigen'];
    $ActivoFijoID = $_POST['ActivoFijoID'];
    $TipoImpuesto = $_POST['TipoImpuesto'];
    $TasaDeImpuesto = $_POST['TasaDeImpuesto'];
    $GuiaAereaConocimientoEmbarque = $_POST['GuiaAereaConocimientoEmbarque'];
    $FacturaComercial = $_POST['FacturaComercial'];
    $ContribuyenteID = $_POST['ContribuyenteID'];
    $AvisoElectronicoImportacionExportacion = $_POST['AvisoElectronicoImportacionExportacion'];
    $FechaCruceAviso = $_POST['FechaCruceAviso'];

    try {
        // Query para actualizar el activo fijo aduanero en la base de datos
        $actualizar_query = "UPDATE aduanaactivosfijos SET
            NumeroPedimento = '$NumeroPedimento',
            ClaveAduana = '$ClaveAduana',
            patente = '$patente',
            NumeroDoc = '$NumeroDoc',
            FechaPedimento = '$FechaPedimento',
            ClavePedimento = '$ClavePedimento',
            PaisOrigen = '$PaisOrigen',
            ActivoFijoID = '$ActivoFijoID',
            TipoImpuesto = '$TipoImpuesto',
            TasaDeImpuesto = '$TasaDeImpuesto',
            GuiaAereaConocimientoEmbarque = '$GuiaAereaConocimientoEmbarque',
            FacturaComercial = '$FacturaComercial',
            ContribuyenteId = '$ContribuyenteID',
            AvisoElectronicoImportacionExportacion = '$AvisoElectronicoImportacionExportacion',
            FechaCruceAviso = '$FechaCruceAviso'
            WHERE IdActivoFijo = $IdActivoFijo";

        // Ejecutar la consulta de actualización
        if (mysqli_query($conn, $actualizar_query)) {
            // Redireccionar a la página de origen con un mensaje de éxito
            header("Location: aduanasActivo.php?mensaje=exito");
            exit();
        } else {
            // Si la consulta de actualización falla, lanzar una excepción
            throw new Exception("Error al realizar la actualización en la base de datos");
        }
    } catch (Exception $e) {
        // Manejar el error y redireccionar a la página de origen con un mensaje de error
        header("Location: aduanasActivo.php?mensaje=error");
        exit();
    }
} else {
    // Si el método de solicitud no es POST, redireccionar a una página de error o mostrar un mensaje de error
    echo "Acceso no permitido.";
}
