<?php
include 'startSession.php';

// Verificar si se recibieron los datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar a la base de datos
    include('conexion.php');

    // Obtener los datos del formulario
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

    // Preparar la consulta SQL para insertar los datos en la tabla correspondiente
    $sql = "INSERT INTO interfasemovimientos (ConsolidadoMovimientos, MaterialID, ProductoID, InterfaseEntradaID, InterfaseSalidaID, Faltantes, Sobrantes, Mermas, ConsumoReal, DescripcionMercancia, UnidadMedida, CantidadMercancia, ValorUnitarioDolares, MontoTotalDolares, FechaRecuperacion, IdentificadorSistemaCorporativo, ContribuyenteID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Preparar la sentencia
    $stmt = mysqli_prepare($conn, $sql);

    // Vincular parámetros a la declaración preparada
    mysqli_stmt_bind_param($stmt, "siiiiiiidssdssssi", $ConsolidadoMovimientos, $MaterialID, $ProductoID, $InterfaseEntradaID, $InterfaseSalidaID, $Faltantes, $Sobrantes, $Mermas, $ConsumoReal, $DescripcionMercancia, $UnidadMedida, $CantidadMercancia, $ValorUnitarioDolares, $MontoTotalDolares, $FechaRecuperacion, $IdentificadorSistemaCorporativo, $ContribuyenteID);

    // Ejecutar la declaración
    mysqli_stmt_execute($stmt);

    // Verificar si se insertaron los datos correctamente
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header("Location: movimientosmanu.php?mensaje=exito_registro");
    } else {
        echo "Error al insertar los datos.";
    }

    // Cerrar la conexión y la sentencia
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
