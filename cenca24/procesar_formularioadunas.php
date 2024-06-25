<?php
include 'startSession.php';

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir archivo de conexión a la base de datos
    include "conexion.php";

    // Obtener los datos del formulario
    $AduanaEntradaID = $_POST['AduanaEntradaID'];
    $NumeroPedimento = $_POST['NumeroPedimento'];
    $ClavePedimento = $_POST['ClavePedimento'];
    $FechaPedimento = $_POST['FechaPedimento'];
    $CantidadSalidaAd = $_POST['CantidadSalidaAd'];
    $ProveedorID = $_POST['ProveedorID'];
    $ContribuyenteID = $_POST['ContribuyenteID'];
    $PaisOrigenMercancia = $_POST['PaisOrigenMercancia'];
    $TipoImpuesto = $_POST['TipoImpuesto'];
    $TasaDeImpuesto = $_POST['TasaDeImpuesto'];
    $FacturaComercial = $_POST['FacturaComercial'];
    $AvisoElectronico = $_POST['AvisoElectronico'];
    $FechaCruce = $_POST['FechaCruce'];
    $SubmanufacturaID = $_POST['SubmanufacturaID'];
    $AgenteAduanalID = $_POST['AgenteAduanalID'];
    $ClienteID = $_POST['ClienteID'];

    // Verificar si se seleccionó un material o un producto
    if (isset($_POST['MaterialID'])) {
        $MaterialID = $_POST['MaterialID'];
    } else {
        // Si no se seleccionó un material, redirigir con un mensaje de error
        header("Location: formulario.php?error=Seleccione un material");
        exit();
    }

    if (isset($_POST['ProductoID'])) {
        $ProductoID = $_POST['ProductoID'];
    } else {
        // Si no se seleccionó un producto, redirigir con un mensaje de error
        header("Location: formulario.php?error=Seleccione un producto");
        exit();
    }

    try {
        // Construir la consulta SQL
        $query = "INSERT INTO aduanasalidas (AduanaEntradaID, NumeroPedimento, ClavePedimento, FechaPedimento, MaterialID, CantidadSalidaAd, ProveedorID, ContribuyenteID, PaisOrigenMercancia, tipoImpuesto, TasaDeImpuesto, FacturaComercial, AvisoElectronico, FechaCruce, SubmanufacturaID, AgenteAduanalID, ClienteID, ProductoID) 
                  VALUES ('$AduanaEntradaID', '$NumeroPedimento', '$ClavePedimento', '$FechaPedimento', '$MaterialID', '$CantidadSalidaAd', '$ProveedorID', '$ContribuyenteID', '$PaisOrigenMercancia', '$TipoImpuesto', '$TasaDeImpuesto', '$FacturaComercial', '$AvisoElectronico', '$FechaCruce', '$SubmanufacturaID', '$AgenteAduanalID', '$ClienteID', '$ProductoID')";

        // Ejecutar la consulta
        if (mysqli_query($conn, $query)) {
            // Éxito al registrar, redirigir a la página de información aduanera
            header("Location: infoaduanera.php");
            exit();
        } else {
            // Error al registrar, lanzar una excepción
            throw new Exception("Error al realizar la inserción en la base de datos: " . mysqli_error($conn));
        }
    } catch (Exception $e) {
        // Manejar el error redirigiendo a la página de información aduanera con un mensaje de error
        header("Location: infoaduanera.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Si no se envió el formulario, mostrar mensaje de acceso no permitido
    echo "Acceso no permitido.";
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
