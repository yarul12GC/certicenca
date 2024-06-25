<?php
include 'startSession.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('conexion.php');

    $idMovimiento = $_POST['InterfaseMovimientoID']; 
    $ConsolidadoMovimientos = $_POST['ConsolidadoMovimientos'];
    $MaterialID = $_POST['MaterialID'];
    $ProductoID = $_POST['ProductoID'];
    $InterfaseEntradaID = $_POST['InterfaseEntradaID'];
    $InterfaseSalidaID = $_POST['InterfaseSalidaID'];
    $Faltantes = $_POST['Faltantes'];
    $Sobrantes = $_POST['Sobrantes'];
    $Mermas = $_POST['Mermas'];
    $ConsumoReal = $_POST['ConsumoReal'];
    $DescripcionMercancia = $_POST['DescripcionMercancia'];
    $UnidadMedida = $_POST['UnidadMedida'];
    $CantidadMercancia = $_POST['CantidadMercancia'];
    $ValorUnitarioDolares = $_POST['ValorUnitarioDolares'];
    $MontoTotalDolares = $_POST['MontoTotalDolares'];
    $FechaRecuperacion = $_POST['FechaRecuperacion'];
    $IdentificadorSistemaCorporativo = $_POST['IdentificadorSistemaCorporativo'];
    $ContribuyenteID = $_POST['ContribuyenteID'];

    $sql = "UPDATE interfasemovimientos SET
    ConsolidadoMovimientos='$ConsolidadoMovimientos', 
    MaterialID='$MaterialID',
    ProductoID='$ProductoID',
    InterfaseEntradaID='$InterfaseEntradaID',
    InterfaseSalidaID='$InterfaseSalidaID',
    Faltantes='$Faltantes',
    Sobrantes='$Sobrantes',
    Mermas='$Mermas',
    ConsumoReal='$ConsumoReal',
    DescripcionMercancia='$DescripcionMercancia',
    UnidadMedida='$UnidadMedida', 
    CantidadMercancia='$CantidadMercancia', 
    ValorUnitarioDolares='$ValorUnitarioDolares', 
    MontoTotalDolares='$MontoTotalDolares', 
    FechaRecuperacion='$FechaRecuperacion', 
    IdentificadorSistemaCorporativo='$IdentificadorSistemaCorporativo', 
    ContribuyenteID='$ContribuyenteID'
    WHERE InterfaseMovimientoID='$idMovimiento'";
    
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header("Location: movimientosmanu.php?mensaje=exito");
    } else {
        echo "Error al actualizar los datos: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
