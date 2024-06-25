<?php
include 'startSession.php';
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $AduanaEntradaID = $_POST['AduanaEntradaID'];
    $NumeroPedimento = $_POST['NumeroPedimento'];
    $ClaveAduana = $_POST['ClaveAduana'];
    $patente = $_POST['patente'];
    $NumeroDoc = $_POST['NumeroDoc'];
    $ClavePedimento = $_POST['ClavePedimento'];
    $FechaPedimento = $_POST['FechaPedimento'];
    $MaterialID = $_POST['material'];
    $CantidadEntradaAduana = $_POST['CantidadEntradaAduana'];
    $ProveedorID = $_POST['proveedor'];
    $ContribuyenteID = $_POST['ContribuyenteID'];
    $PaisOrigenMercancia = $_POST['PaisOrigenMercancia'];
    $tipoImpuesto = $_POST['tipoImpuesto'];
    $TasaDeImpuesto = $_POST['TasaDeImpuesto'];
    $FacturaComercial = $_POST['FacturaComercial'];
    $AvisoElectronico = $_POST['AvisoElectronico'];
    $FechaCruce = $_POST['FechaCruce'];
    $SubmanufacturaID = $_POST['SubmanufacturaID'];
    $AgenteAduanalID = $_POST['AgenteAduanalID'];
    $ProductoID = $_POST['ProductoID'];

    try {

        // Realizar la actualización en la base de datos
        $actualizar_query =
            "UPDATE aduanaentradas SET 
            NumeroPedimento = '$NumeroPedimento', 
            ClaveAduana = '$ClaveAduana', 
            patente = '$patente',
            NumeroDoc = $NumeroDoc,
            ClavePedimento = '$ClavePedimento',
            FechaPedimento = '$FechaPedimento',
            MaterialID = $MaterialID,
            CantidadEntradaAduana = $CantidadEntradaAduana,
            ProveedorID = $ProveedorID,
            ContribuyenteID = $ContribuyenteID,
            PaisOrigenMercancia = '$PaisOrigenMercancia',
            tipoImpuesto = '$tipoImpuesto',
            TasaDeImpuesto = $TasaDeImpuesto,
            FacturaComercial = '$FacturaComercial',
            AvisoElectronico = '$AvisoElectronico',
            FechaCruce = '$FechaCruce',
            SubmanufacturaID = $SubmanufacturaID,
            AgenteAduanalID = $AgenteAduanalID,
            ProductoID = $ProductoID
            WHERE AduanaEntradaID = $AduanaEntradaID";

        if (mysqli_query($conn, $actualizar_query)) {
            // Éxito al actualizar
            header("Location: aduanasEntradas.php?mensaje=exito");
            exit();
        } else {
            // Error al actualizar
            throw new Exception("Error al realizar la actualización en la base de datos");
        }
    } catch (Exception $e) {
        // Manejar el error sin detener la ejecución de la página
        header("Location: aduanasEntradas.php?mensaje=error");
        exit();
    }
} else {
    echo "Acceso no permitido.";
}
