<?php
include 'startSession.php';
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $NumeroPedimento = $_POST['NumeroPedimento'];
    $ClaveAduana = $_POST['ClaveAduana'];
    $patente = $_POST['patente'];
    $NumeroDoc = $_POST['NumeroDoc'];
    $ClavePedimento = $_POST['ClavePedimento'];
    $FechaPedimento = $_POST['FechaPedimento'];
    $MaterialID = isset($_POST['MaterialID']) ? $_POST['MaterialID'] : 'NULL';
    $ProductoID = isset($_POST['ProductoID']) ? $_POST['ProductoID'] : 'NULL';
    $CantidadEntradaAduana = $_POST['CantidadEntradaAduana'];
    $ProveedorID = $_POST['ProveedorID'];
    $ContribuyenteID = $_POST['ContribuyenteID'];
    $PaisOrigenMercancia = $_POST['PaisOrigenMercancia'];
    $tipoImpuesto = $_POST['tipoImpuesto'];
    $TasaDeImpuesto = $_POST['TasaDeImpuesto'];
    $FacturaComercial = $_POST['FacturaComercial'];
    $AvisoElectronico = $_POST['AvisoElectronico'];
    $FechaCruce = $_POST['FechaCruce'];
    $SubmanufacturaID = $_POST['SubmanufacturaID'];
    $AgenteAduanalID = $_POST['AgenteAduanalID'];

    try {
        // Construir la consulta de inserción
        $query = "INSERT INTO aduanaentradas (NumeroPedimento, ClaveAduana, patente, NumeroDoc, ClavePedimento, FechaPedimento, MaterialID, ProductoID, CantidadEntradaAduana, ProveedorID, ContribuyenteID, PaisOrigenMercancia, tipoImpuesto, TasaDeImpuesto, FacturaComercial, AvisoElectronico, FechaCruce, SubmanufacturaID, AgenteAduanalID) 
                  VALUES ('$NumeroPedimento', '$ClaveAduana', '$patente', '$NumeroDoc', '$ClavePedimento', '$FechaPedimento', $MaterialID, $ProductoID, '$CantidadEntradaAduana', '$ProveedorID', '$ContribuyenteID', '$PaisOrigenMercancia', '$tipoImpuesto', '$TasaDeImpuesto', '$FacturaComercial', '$AvisoElectronico', '$FechaCruce', '$SubmanufacturaID', '$AgenteAduanalID')";

        // Ejecutar la consulta
        if (mysqli_query($conn, $query)) {
            // Éxito al registrar
            header("Location: aduanasEntradas.php?mensaje=exito");
            exit();
        } else {
            // Error al registrar
            throw new Exception("Error al realizar la inserción en la base de datos");
        }
    } catch (Exception $e) {
        // Manejar el error sin detener la ejecución de la página
        header("Location: aduanasEntradas.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    echo "Acceso no permitido.";
}

// Cerrar la conexión
mysqli_close($conn);
?>
